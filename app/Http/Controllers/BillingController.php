<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\ServicesAvailed;
use App\Models\TreatmentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    public function getAllBillings(Request $request)
{
    Log::info("Fetching all billings");

    $activeTab = $request->input('activeTab'); // Get the activeTab parameter
    Log::info("Active tab received", ['activeTab' => $activeTab]);

    $billings = Billing::with([
        'appointment' => function ($query) {
            $query->with([
                'patient.user',
                'dentist.user',
                'servicesAvailed' => function ($query) {
                    $query->with(['service']);
                }
            ]);
        },
        'payments.paymentMethod'
    ])->get();

    $standalonePayments = Payment::whereNull('BillingID')
        ->with('paymentMethod')
        ->join('patients', 'payments.PatientID', '=', 'patients.PatientID')
        ->join('users', 'patients.UserID', '=', 'users.UserID')
        ->select(
            'payments.*',
            DB::raw("CONCAT(COALESCE(users.FirstName, ''), ' ', COALESCE(users.LastName, '')) as PatientName")
        )
        ->get();

    $billingEntries = $billings->flatMap(function ($billing) {
        $appointment = $billing->appointment;
        $servicesAvailed = $appointment ? $appointment->servicesAvailed : collect();

        $displayServices = $appointment && strtolower($appointment->AppointmentStatus) === 'completed'
            ? $servicesAvailed
            : $servicesAvailed->filter(fn($sa) => $sa->Status === 'Completed');

        $procedure = $displayServices->isNotEmpty()
            ? $displayServices->map(fn($sa) => $sa->service->ServiceName)->implode(' and ')
            : 'No services';

        $totalAmount = floatval($billing->TotalAmount);
        $discount = floatval($billing->Discount ?? 0);
        $payableAmount = $totalAmount - $discount;

        $payments = $billing->payments->sortBy('created_at');
        $amountPaid = $payments->sum('AmountPaid');
        $balance = max(0, $payableAmount - $amountPaid);

        // Only recalculate and update if TotalAmount is null or explicitly flagged for recalculation
        $calculatedTotalAmount = $displayServices->sum(function ($sa) {
            return $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
        });
        if ($billing->TotalAmount === null || $billing->force_recalculate ?? false) {
            Log::warning("Recalculating TotalAmount for BillingID {$billing->BillingID} due to null or forced update", [
                'StoredTotalAmount' => $totalAmount,
                'CalculatedTotalAmount' => $calculatedTotalAmount,
            ]);
            $totalAmount = $calculatedTotalAmount;
            $payableAmount = $totalAmount - $discount;
            $balance = max(0, $payableAmount - $amountPaid);
            $billingStatus = 'Unpaid';
            if ($amountPaid >= $payableAmount && $amountPaid > 0) {
                $billingStatus = 'Paid';
            } elseif ($amountPaid > 0) {
                $billingStatus = 'Partially Paid';
            }
            $billing->update([
                'TotalAmount' => $totalAmount,
                'Balance' => $balance,
                'BillingStatus' => $billingStatus,
            ]);
            $billing->refresh();
            $billingStatus = $billing->BillingStatus;
        } else {
            // Log the balance for debugging, matching the 9,000 log entry
            Log::info("Returning balance for PatientID: {$appointment?->patient?->PatientID}", ['balance' => $balance]);
        }

        $nonInsuranceAmountPaid = $payments->filter(function ($payment) {
            $methodType = $payment->paymentMethod ? $payment->paymentMethod->MethodType : null;
            return strtolower($methodType ?? '') !== 'insurance';
        })->sum('AmountPaid');

        $billingStatus = $billing->BillingStatus;

        $paymentDate = $payments->isNotEmpty() ? $payments->sortByDesc('created_at')->first()->created_at->toDateTimeString() : null;

        // Prioritize insurance payment for ApprovalCode and LOE
        $insurancePayment = $payments->firstWhere('paymentMethod.MethodType', 'Insurance');
        $approvalCode = $insurancePayment ? $insurancePayment->ApprovalCode : null;
        $loe = $insurancePayment ? $insurancePayment->LOE : null;
    
            if ($billingStatus === 'Unpaid') {
                $paymentMethodName = 'N/A';
                $paymentMethodType = null;
                $referenceID = null;
                $methodChange = 0;
    
                if ($payments->isNotEmpty()) {
                    $firstPayment = $payments->first();
                    $paymentMethodName = $firstPayment->paymentMethod ? $firstPayment->paymentMethod->MethodName : 'N/A';
                    $paymentMethodType = $firstPayment->paymentMethod ? $firstPayment->paymentMethod->MethodType : null;
                    $methodChange = $firstPayment->Change ?? 0;
                    if (in_array($paymentMethodType, ['E-Wallet', 'Bank Payment'])) {
                        $referenceID = $firstPayment->ReferenceID ?? null;
                    }
                }
    
                $services = $displayServices->map(function ($sa) use ($paymentMethodName, $methodChange) {
                    $serviceCost = $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
                    return [
                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                        'ServiceName' => $sa->service->ServiceName,
                        'Cost' => floatval($sa->service->Cost),
                        'UpdatedPrice' => $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : null,
                        'AmountPaid' => 0,
                        'Balance' => $serviceCost,
                        'PaymentStatus' => 'Unpaid',
                        'PaymentMethod' => $paymentMethodName,
                        'Change' => $methodChange,
                    ];
                })->all();
    
                return [[
                    'BillingID' => $billing->BillingID,
                    'AppointmentID' => $billing->AppointmentID,
                    'PatientID' => $appointment?->patient?->PatientID ?? 'N/A',
                    'PatientName' => $appointment?->patient?->user
                        ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                        : 'N/A',
                    'AssignedDentist' => $appointment?->dentist?->user
                        ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                        : 'N/A',
                    'AppointmentDateTime' => $appointment
                        ? $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime
                        : 'N/A',
                    'Procedure' => $procedure,
                    'Amount' => $totalAmount,
                    'AmountPaid' => $amountPaid,
                    'TotalAmount' => $totalAmount,
                    'Balance' => $balance,
                    'BillingStatus' => $billingStatus,
                    'PaymentDate' => null,
                    'PaymentMethod' => $paymentMethodName,
                    'ReferenceID' => $referenceID,
                    'Change' => $methodChange,
                    'services' => $services,
                    'IsStandalonePayment' => false,
                    'NonInsuranceAmountPaid' => $nonInsuranceAmountPaid,
                    'Remarks' => $billing->Remarks ?? '',
                    'ApprovalCode' => $approvalCode,
                    'LOE' => $loe,
                ]];
            }
    
            $entries = [];
            $insurancePayments = $payments->filter(function ($payment) {
                return strtolower($payment->paymentMethod->MethodType ?? '') === 'insurance';
            });
            $nonInsurancePayments = $payments->filter(function ($payment) {
                return strtolower($payment->paymentMethod->MethodType ?? '') !== 'insurance';
            });
    
            // Get the insurance payment method for unpaid services in the non-insurance entry
            $insurancePaymentMethod = $insurancePayments->isNotEmpty()
                ? ($insurancePayments->first()->paymentMethod ? $insurancePayments->first()->paymentMethod->MethodName : 'N/A')
                : 'N/A';
    
            // Create a mapping of services to their intended payment methods based on modal input order
            $servicePaymentMap = [];
            $paymentIndex = 0;
            foreach ($displayServices as $sa) {
                if ($paymentIndex < $payments->count()) {
                    $servicePaymentMap[$sa->ServiceAvailedID] = $payments[$paymentIndex];
                    $paymentIndex++;
                } else {
                    // If there are more services than payments, default to the last payment method
                    $servicePaymentMap[$sa->ServiceAvailedID] = $payments->last();
                }
            }
    
            if ($nonInsurancePayments->isNotEmpty()) {
                $methodAmountPaid = $nonInsurancePayments->sum('AmountPaid');
                $methodChange = $nonInsurancePayments->sum('Change');
    
                $servicesData = $displayServices->map(function ($sa) use ($nonInsurancePayments, $insurancePayments, $servicePaymentMap, $insurancePaymentMethod) {
                    $serviceCost = $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
                    $serviceAvailedId = $sa->ServiceAvailedID;
                    $serviceAmountPaid = 0;
                    $paymentMethodName = 'N/A';
                    $paymentMethodType = null;
                    $serviceChange = 0;
                    $referenceID = null;
    
                    // Get the intended payment for this service
                    $intendedPayment = $servicePaymentMap[$serviceAvailedId] ?? null;
                    $intendedPaymentMethod = $intendedPayment && $intendedPayment->paymentMethod
                        ? $intendedPayment->paymentMethod
                        : null;
                    $intendedMethodType = $intendedPaymentMethod ? $intendedPaymentMethod->MethodType : null;
                    $intendedPaymentMethodName = $intendedPaymentMethod ? $intendedPaymentMethod->MethodName : 'N/A';
    
                    // Allocate payments based on the intended method type
                    if (strtolower($intendedMethodType ?? '') === 'insurance') {
                        $relevantPayments = $insurancePayments;
                    } else {
                        $relevantPayments = $nonInsurancePayments;
                    }
    
                    $remainingPayments = $relevantPayments->values();
                    $paymentIndex = 0;
                    $currentPayment = $remainingPayments[$paymentIndex] ?? null;
                    $remainingPaymentAmount = $currentPayment ? floatval($currentPayment->AmountPaid) : 0;
    
                    if ($currentPayment && $remainingPaymentAmount > 0) {
                        $amountToApply = min($remainingPaymentAmount, $serviceCost);
                        $serviceAmountPaid = $amountToApply;
                        $remainingPaymentAmount -= $amountToApply;
    
                        $paymentMethodName = $currentPayment->paymentMethod ? $currentPayment->paymentMethod->MethodName : 'N/A';
                        $paymentMethodType = $currentPayment->paymentMethod ? $currentPayment->paymentMethod->MethodType : null;
                        $serviceChange = floatval($currentPayment->Change ?? 0);
                        if (in_array($paymentMethodType, ['E-Wallet', 'Bank Payment'])) {
                            $referenceID = $currentPayment->ReferenceID ?? null;
                        }
    
                        if ($remainingPaymentAmount <= 0) {
                            $paymentIndex++;
                            $currentPayment = $remainingPayments[$paymentIndex] ?? null;
                            $remainingPaymentAmount = $currentPayment ? floatval($currentPayment->AmountPaid) : 0;
                        }
                    }
    
                    $serviceData = [
                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                        'ServiceName' => $sa->service->ServiceName,
                        'Cost' => floatval($sa->service->Cost),
                        'UpdatedPrice' => $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : null,
                        'AmountPaid' => floatval($serviceAmountPaid),
                        'Balance' => floatval($serviceCost - $serviceAmountPaid),
                        'PaymentStatus' => $serviceAmountPaid >= $serviceCost ? 'Paid' : ($serviceAmountPaid > 0 ? 'Unpaid' : 'Unpaid'),
                        'PaymentMethod' => $intendedPaymentMethodName, // Use the intended payment method
                        'Change' => $serviceChange,
                    ];
    
                    if (in_array($paymentMethodType, ['E-Wallet', 'Bank Payment'])) {
                        $serviceData['ReferenceID'] = $referenceID;
                    }
    
                    return $serviceData;
                })->all();
    
                $methodProcedure = array_map(fn($service) => $service['ServiceName'], $servicesData);
                $methodProcedure = count($methodProcedure) > 1 
                    ? implode(', ', array_slice($methodProcedure, 0, -1)) . ' and ' . end($methodProcedure)
                    : implode('', $methodProcedure);
                $methodTotalAmount = array_sum(array_column($servicesData, 'Cost'));
    
                $entries[] = [
                    'BillingID' => $billing->BillingID,
                    'AppointmentID' => $billing->AppointmentID,
                    'PatientID' => $appointment?->patient?->PatientID ?? 'N/A',
                    'PatientName' => $appointment?->patient?->user
                        ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                        : 'N/A',
                    'AssignedDentist' => $appointment?->dentist?->user
                        ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                        : 'N/A',
                    'AppointmentDateTime' => $appointment
                        ? $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime
                        : 'N/A',
                    'Procedure' => $methodProcedure,
                    'Amount' => floatval($methodTotalAmount),
                    'AmountPaid' => floatval($methodAmountPaid),
                    'TotalAmount' => floatval($methodTotalAmount),
                    'Balance' => floatval($balance),
                    'BillingStatus' => $billingStatus,
                    'PaymentDate' => $paymentDate,
                    'PaymentMethod' => count($nonInsurancePayments) > 1 ? 'Multiple' : ($nonInsurancePayments->first()->paymentMethod->MethodName ?? 'N/A'),
                    'ReferenceID' => null,
                    'Change' => floatval($methodChange),
                    'services' => $servicesData,
                    'IsStandalonePayment' => false,
                    'NonInsuranceAmountPaid' => $nonInsuranceAmountPaid,
                    'Remarks' => $billing->Remarks ?? '',
                    'ApprovalCode' => $approvalCode,
                    'LOE' => $loe,
                ];
            }
    
            foreach ($insurancePayments as $payment) {
                $paymentMethodName = $payment->paymentMethod ? $payment->paymentMethod->MethodName : 'N/A';
                $paymentMethodType = $payment->paymentMethod ? $payment->paymentMethod->MethodType : null;
                $paymentMethodId = $payment->PaymentMethodID;
                $methodChange = $payment->Change ?? 0;
                $methodAmountPaid = floatval($payment->AmountPaid);
    
                // Filter services for the insurance entry to exclude fully paid non-insurance services
                $methodServices = $displayServices->filter(function ($sa) use ($nonInsurancePayments, $methodAmountPaid, $servicePaymentMap) {
                    $serviceAvailedId = $sa->ServiceAvailedID;
                    $serviceCost = $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
                    $intendedPayment = $servicePaymentMap[$serviceAvailedId] ?? null;
                    $intendedMethodType = $intendedPayment && $intendedPayment->paymentMethod
                        ? $intendedPayment->paymentMethod->MethodType
                        : null;
    
                    // Only include services intended for insurance
                    if (strtolower($intendedMethodType ?? '') !== 'insurance') {
                        return false;
                    }
    
                    $serviceNonInsurancePaid = 0;
    
                    // Calculate how much of this service was paid by non-insurance payments
                    $remainingPayments = $nonInsurancePayments->values();
                    $paymentIndex = 0;
                    $currentPayment = $remainingPayments[$paymentIndex] ?? null;
                    $remainingPaymentAmount = $currentPayment ? floatval($currentPayment->AmountPaid) : 0;
    
                    if ($currentPayment && $remainingPaymentAmount > 0) {
                        $amountToApply = min($remainingPaymentAmount, $serviceCost);
                        $serviceNonInsurancePaid = $amountToApply;
                        $remainingPaymentAmount -= $amountToApply;
    
                        if ($remainingPaymentAmount <= 0) {
                            $paymentIndex++;
                            $currentPayment = $remainingPayments[$paymentIndex] ?? null;
                            $remainingPaymentAmount = $currentPayment ? floatval($currentPayment->AmountPaid) : 0;
                        }
                    }
    
                    $serviceBalance = $serviceCost - $serviceNonInsurancePaid;
                    // Include the service if it's unpaid (after non-insurance payments) or has an insurance payment
                    return $serviceBalance > 0 || $methodAmountPaid > 0;
                });
    
                if ($methodServices->isEmpty()) {
                    continue; // Skip if there are no services after filtering
                }
    
                $servicesData = $methodServices->map(function ($sa) use ($paymentMethodName, $methodChange, $methodAmountPaid, $methodServices) {
                    $serviceCost = $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
                    $totalServiceCost = $methodServices->sum(function ($s) {
                        return $s->UpdatedPrice !== null ? floatval($s->UpdatedPrice) : floatval($s->service->Cost);
                    });
                    $proportion = $totalServiceCost > 0 ? $serviceCost / $totalServiceCost : 0;
                    $serviceAmountPaid = $methodAmountPaid * $proportion;
    
                    return [
                        'ServiceAvailedID' => $sa->ServiceAvailedID,
                        'ServiceName' => $sa->service->ServiceName,
                        'Cost' => floatval($sa->service->Cost),
                        'UpdatedPrice' => $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : null,
                        'AmountPaid' => floatval($serviceAmountPaid),
                        'Balance' => floatval($serviceCost - $serviceAmountPaid),
                        'PaymentStatus' => $serviceAmountPaid >= $serviceCost ? 'Paid' : ($serviceAmountPaid > 0 ? 'Unpaid' : 'Unpaid'),
                        'PaymentMethod' => $paymentMethodName,
                        'Change' => floatval($methodChange),
                    ];
                })->all();
    
                $serviceNames = $methodServices->map(fn($sa) => $sa->service->ServiceName)->toArray();
                $methodProcedure = count($serviceNames) > 1 
                    ? implode(', ', array_slice($serviceNames, 0, -1)) . ' and ' . end($serviceNames)
                    : implode('', $serviceNames);
                $methodTotalAmount = $methodServices->sum(function ($sa) {
                    return $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($sa->service->Cost);
                });
    
                $entries[] = [
                    'BillingID' => $billing->BillingID . '_PM_' . $paymentMethodId,
                    'AppointmentID' => $billing->AppointmentID,
                    'PatientID' => $appointment?->patient?->PatientID ?? 'N/A',
                    'PatientName' => $appointment?->patient?->user
                        ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                        : 'N/A',
                    'AssignedDentist' => $appointment?->dentist?->user
                        ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                        : 'N/A',
                    'AppointmentDateTime' => $appointment
                        ? $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime
                        : 'N/A',
                    'Procedure' => $methodProcedure,
                    'Amount' => floatval($methodTotalAmount),
                    'AmountPaid' => floatval($methodAmountPaid),
                    'TotalAmount' => floatval($methodTotalAmount),
                    'Balance' => floatval($methodTotalAmount - $methodAmountPaid),
                    'BillingStatus' => $billingStatus,
                    'PaymentDate' => $payment->PaymentDate ? $payment->PaymentDate->toDateTimeString() : null,
                    'PaymentMethod' => $paymentMethodName,
                    'ReferenceID' => in_array($paymentMethodType, ['E-Wallet', 'Bank Payment']) ? $payment->ReferenceID : null,
                    'Change' => floatval($methodChange),
                    'services' => $servicesData,
                    'IsStandalonePayment' => false,
                    'NonInsuranceAmountPaid' => 0,
                    'Remarks' => $billing->Remarks ?? '',
                    'ApprovalCode' => $payment->ApprovalCode,
                    'LOE' => $payment->LOE,
                ];
            }
    
            return $entries;
        });
    
        $standaloneEntries = $standalonePayments->map(function ($payment) {
            $amountPaid = floatval($payment->AmountPaid);
            $paymentDate = $payment->PaymentDate ? $payment->PaymentDate->toDateTimeString() : $payment->created_at->toDateTimeString();
            $methodName = $payment->paymentMethod ? $payment->paymentMethod->MethodName : 'N/A';
            $methodType = $payment->paymentMethod ? $payment->paymentMethod->MethodType : null;
    
            $ledgerRequest = new Request();
            $ledgerResponse = $this->getPatientLedger($ledgerRequest, $payment->PatientID);
            $ledgerEntries = $ledgerResponse->getData()->ledger ?? [];
    
            $lastService = 'Standalone Payment';
            $lastServiceCost = $amountPaid;
            $remainingBalance = 0;
            $paymentFound = false;
    
            foreach ($ledgerEntries as $entry) {
                if ($entry->Service && $entry->Debit > 0 && !$paymentFound) {
                    $lastService = $entry->Service;
                    $lastServiceCost = $entry->Debit;
                }
                if ($entry->PaymentMethod === $methodName && $entry->Reference === ($payment->ReferenceID ?? 'Payment #' . $payment->PaymentID)) {
                    $remainingBalance = $entry->Balance;
                    $paymentFound = true;
                    break;
                }
            }
    
            return [
                'BillingID' => 'SP_' . $payment->PaymentID,
                'AppointmentID' => null,
                'PatientID' => $payment->PatientID,
                'PatientName' => $payment->PatientName,
                'AssignedDentist' => 'N/A',
                'AppointmentDateTime' => null,
                'Procedure' => $lastService,
                'Amount' => floatval($amountPaid),
                'AmountPaid' => floatval($amountPaid),
                'TotalAmount' => floatval($lastServiceCost),
                'Balance' => floatval($remainingBalance),
                'BillingStatus' => $amountPaid > 0 ? 'Paid' : 'Unpaid',
                'PaymentDate' => $paymentDate,
                'PaymentMethod' => $methodName,
                'ReferenceID' => $methodType === 'Cash' ? null : $payment->ReferenceID,
                'Change' => floatval($payment->Change),
                'services' => [
                    [
                        'ServiceAvailedID' => null,
                        'ServiceName' => $lastService,
                        'Cost' => floatval($lastServiceCost),
                        'UpdatedPrice' => null,
                        'AmountPaid' => floatval($amountPaid),
                        'Balance' => floatval($remainingBalance),
                        'PaymentStatus' => $amountPaid > 0 ? 'Paid' : 'Unpaid',
                        'PaymentMethod' => $methodName,
                        'ReferenceID' => $methodType === 'Cash' ? null : $payment->ReferenceID,
                        'Change' => floatval($payment->Change),
                    ],
                ],
                'IsStandalonePayment' => true,
                'NonInsuranceAmountPaid' => $methodType !== 'Insurance' ? $amountPaid : 0,
                'Remarks' => $payment->Notes ?? '',
                'ApprovalCode' => $payment->ApprovalCode,
                'LOE' => $payment->LOE,
            ];
        });
    
        $allEntries = $billingEntries->concat($standaloneEntries);
    
        // Filter entries based on activeTab
        $filteredEntries = $allEntries->filter(function ($entry) use ($activeTab) {
            $isInsuranceEntry = strtolower($entry['PaymentMethod']) !== 'n/a' &&
                                in_array(strtolower($entry['PaymentMethod']), ['medicard', 'maxicare']);
            $billingStatus = strtolower($entry['BillingStatus']);
    
            if ($activeTab === 'insurance') {
                // Include entries with insurance payment methods, regardless of payment status
                return $isInsuranceEntry;
            } elseif ($activeTab === 'unpaid') {
                return $billingStatus === 'unpaid' || $billingStatus === 'Unpaid';
            } elseif ($activeTab === 'paid') {
                return $billingStatus === 'paid' && !$isInsuranceEntry; // Exclude insurance entries from Paid tab
            }
    
            return true; // Default: return all entries if no activeTab specified
        });
    
        Log::info("Returning filtered billings for activeTab: $activeTab", ['billings' => $filteredEntries->toArray()]);
        return response()->json($filteredEntries);
    }

    public function getBilling(Request $request, $appointmentId)
{
    $appointment = Appointment::findOrFail($appointmentId);
    $patientId = $appointment->PatientID;
    $servicesAvailed = $appointment->servicesAvailed;
    $totalCost = 0;
    $existingBilling = null;

    foreach ($servicesAvailed as $sa) {
        $service = $sa->service;
        if ($service->IsMultiVisit) {
            $treatmentProgress = TreatmentProgress::where('PatientID', $patientId)
                ->where('TreatmentName', $service->ServiceName)
                ->where('Status', 'In Progress')
                ->first();

            if ($treatmentProgress) {
                // Find the most recent unpaid billing for this treatment
                $priorBilling = Billing::whereHas('appointment.servicesAvailed', function ($query) use ($treatmentProgress) {
                    $query->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID);
                })->where('Balance', '>', 0)
                    ->whereHas('appointment', function ($query) use ($patientId) {
                        $query->where('PatientID', $patientId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                if ($priorBilling) {
                    $serviceBalance = $priorBilling->Balance;
                    $treatmentProgress->VisitCount += 1;
                    $treatmentProgress->save();
                    // Link the new service_availed to the existing treatment progress
                    DB::table('services_availed')
                        ->where('ServiceAvailedID', $sa->ServiceAvailedID)
                        ->update(['TreatmentProgressID' => $treatmentProgress->TreatmentProgressID]);
                    $existingBilling = $priorBilling;
                    $totalCost += $serviceBalance;
                } else {
                    // Check if all prior billings are paid, skip if fully paid
                    $allPaid = Billing::whereHas('appointment.servicesAvailed', function ($query) use ($treatmentProgress) {
                        $query->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID);
                    })->where('Balance', '=', 0)->count() > 0;
                    if ($allPaid) {
                        Log::info("Treatment fully paid, skipping new billing", [
                            'TreatmentProgressID' => $treatmentProgress->TreatmentProgressID,
                        ]);
                        continue;
                    }
                    // Start a new visit cycle if no unpaid billing
                    $treatmentProgress->VisitCount += 1;
                    $treatmentProgress->save();
                    $serviceBalance = $service->Cost;
                    $totalCost += $serviceBalance;
                    DB::table('services_availed')
                        ->where('ServiceAvailedID', $sa->ServiceAvailedID)
                        ->update(['TreatmentProgressID' => $treatmentProgress->TreatmentProgressID]);
                }
            } else {
                // No existing treatment progress, start a new one
                $treatmentProgress = new TreatmentProgress();
                $treatmentProgress->PatientID = $patientId;
                $treatmentProgress->TreatmentName = $service->ServiceName;
                $treatmentProgress->StartDate = now()->toDateString();
                $treatmentProgress->VisitCount = 1;
                $treatmentProgress->Status = 'In Progress';
                $treatmentProgress->save();
                $serviceBalance = $service->Cost;
                $totalCost += $serviceBalance;
                DB::table('services_availed')
                    ->where('ServiceAvailedID', $sa->ServiceAvailedID)
                    ->update(['TreatmentProgressID' => $treatmentProgress->TreatmentProgressID]);
            }
        } else {
            $totalCost += $sa->UpdatedPrice !== null ? floatval($sa->UpdatedPrice) : floatval($service->Cost);
        }
    }

    if ($totalCost > 0) {
        if ($existingBilling) {
            // Update existing billing with new total cost
            $existingBilling->TotalAmount = $totalCost;
            $existingBilling->Balance = $totalCost; // Recalculate balance if needed
            $existingBilling->save();
            return response()->json(['billing' => $existingBilling], 200);
        } else {
            // Create new billing only if no existing one is reused
            $billing = new Billing();
            $billing->AppointmentID = $appointmentId;
            $billing->TotalAmount = $totalCost;
            $billing->Balance = $totalCost;
            $billing->BillingStatus = 'Unpaid';
            $billing->save();
            return response()->json(['billing' => $billing], 200);
        }
    }

    return response()->json(['message' => 'No billing required for this appointment'], 200);
}

    public function updateBillingBalance($billingId, $paymentAmount) 
    {
    $billing = Billing::find($billingId);
    if ($billing) {
        $billing->Balance -= $paymentAmount;
        if ($billing->Balance <= 0) {
            $billing->BillingStatus = 'Paid';
            $billing->Balance = 0;
        }
        $billing->save();
        Log::info("Billing balance updated", [
            'BillingID' => $billingId,
            'NewBalance' => $billing->Balance,
            'Status' => $billing->BillingStatus,
        ]);
    }
}

    public function updateBilling(Request $request, $id)
{
    Log::info("updateBilling called for ID: $id", ['request' => $request->all()]);

    // Validation rules (unchanged)
    $referenceIdRules = [
        'Cash' => ['all' => ['nullable']],
        'E-Wallet' => ['all' => ['required', 'string', 'regex:/^[A-Za-z0-9]{12,13}$/']],
        'Bank Payment' => ['all' => ['required', 'string', 'regex:/^[A-Za-z0-9]{12,13}$/']],
        'Insurance' => ['all' => ['nullable']],
    ];

    $rules = [
        'TotalAmount' => ['required', 'integer', 'min:0'],
        'Discount' => ['required', 'numeric', 'min:0'],
        'AmountPaid' => ['required', 'numeric', 'min:0'],
        'PaymentMethod' => ['required', 'string'],
        'Change' => ['required', 'numeric', 'min:0'],
        'Remarks' => ['nullable', 'string'],
        'ApprovalCode' => ['nullable', 'string', 'max:50'],
        'LOE' => ['nullable', 'string', 'max:50'],
        'activeTab' => ['required', 'string', 'in:unpaid,insurance,paid'],
        'services' => ['required', 'array'],
        'services.*.ServiceAvailedID' => ['required', 'exists:services_availed,ServiceAvailedID'],
        'services.*.Cost' => ['required', 'numeric', 'min:0'],
        'services.*.AmountPaid' => ['required', 'numeric', 'min:0'],
        'services.*.PaymentMethod' => ['required', 'string'],
        'services.*.ReferenceID' => ['nullable', 'string'],
        'services.*.Change' => ['required', 'numeric', 'min:0'],
    ];

    $validated = $request->validate($rules);

    $primaryPaymentMethod = $request->input('PaymentMethod');
    $totalAmountPaid = $validated['AmountPaid'];
    $activeTab = $request->input('activeTab');

    $paymentMethod = DB::table('payment_methods')
        ->where('MethodName', $primaryPaymentMethod)
        ->first();

    if (!$paymentMethod && $primaryPaymentMethod !== 'N/A') {
        return response()->json(['message' => 'Invalid primary payment method selected'], 400);
    }

    $methodType = $paymentMethod ? $paymentMethod->MethodType : null;
    $methodName = $paymentMethod ? $paymentMethod->MethodName : null;
    $isInsurancePrimary = $methodType === 'Insurance' && in_array($methodName, ['Medicard', 'Maxicare']);

    $services = collect($request->input('services'));
    $hasInsuranceWithPayment = $services->filter(function ($service) {
        $method = DB::table('payment_methods')->where('MethodName', $service['PaymentMethod'])->first();
        return $method && $method->MethodType === 'Insurance' && $service['PaymentStatus'] === 'Paid';
    })->isNotEmpty();

    if ($activeTab === 'insurance' && $hasInsuranceWithPayment) {
        if (!$request->input('ApprovalCode')) {
            return response()->json(['message' => 'Approval Code is required for insurance payments when marking as paid'], 422);
        }

        if ($request->input('ApprovalCode')) {
            if ($isInsurancePrimary) {
                if ($methodName === 'Medicard') {
                    if (!preg_match('/^[A-Z]{2}\s\d{5,7}$/', $request->input('ApprovalCode'))) {
                        return response()->json(['message' => 'Approval Code for Medicard must be 2 letters, a space, then 5-7 digits (e.g., AB 12345)'], 422);
                    }
                } elseif ($methodName === 'Maxicare') {
                    if (!preg_match('/^\d{8,9}$/', $request->input('ApprovalCode'))) {
                        return response()->json(['message' => 'Approval Code for Maxicare must be 8-9 digits (e.g., 123456789)'], 422);
                    }
                    if (!$request->input('LOE')) {
                        return response()->json(['message' => 'LOE # is required for Maxicare'], 422);
                    }
                    if (!preg_match('/^\d{8,9}$/', $request->input('LOE'))) {
                        return response()->json(['message' => 'LOE # for Maxicare must be 8-9 digits (e.g., 987654321)'], 422);
                    }
                }
            }
        }
    }

    if ($primaryPaymentMethod !== 'N/A' && isset($referenceIdRules[$methodType])) {
        $rules['ReferenceID'] = array_merge(
            $referenceIdRules[$methodType]['all'],
            [
                Rule::unique('payments', 'ReferenceID')
                    ->where(fn($query) => $query->where('BillingID', '!=', $id))
                    ->whereNotNull('ReferenceID')
            ]
        );
    }

    $validated = $request->validate($rules);

    $billing = Billing::find($id);
    if (!$billing) {
        Log::warning("Billing not found for ID: $id");
        return response()->json(['message' => 'Billing not found'], 404);
    }

    $appointment = Appointment::with('servicesAvailed.service')->find($billing->AppointmentID);
    if (!$appointment) {
        Log::warning("Appointment not found for AppointmentID: {$billing->AppointmentID}");
        return response()->json(['message' => 'Associated appointment not found'], 404);
    }

    $patientId = $appointment->PatientID;
    $servicesAvailed = $appointment->servicesAvailed;

    DB::beginTransaction();
    try {
        // Update UpdatedPrice in services_availed table (unchanged)
        foreach ($services as $service) {
            $serviceAvailed = $servicesAvailed->firstWhere('ServiceAvailedID', $service['ServiceAvailedID']);
            if (!$serviceAvailed) {
                continue;
            }
            $originalCost = floatval($serviceAvailed->service->Cost);
            $newCost = floatval($service['Cost']);
            if ($serviceAvailed->service->IsMultiVisit) {
    $treatmentProgress = TreatmentProgress::where('PatientID', $patientId)
        ->where('TreatmentName', $serviceAvailed->service->ServiceName)
        ->where('Status', '!=', 'Completed')
        ->first();
    if ($treatmentProgress) {
        $priorServiceAvailed = DB::table('services_availed')
            ->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID)
            ->orderBy('created_at', 'desc')
            ->first();
        $maxAllowedCost = $priorServiceAvailed && $priorServiceAvailed->UpdatedPrice !== null
            ? floatval($priorServiceAvailed->UpdatedPrice)
            : $originalCost;
        if ($newCost > $maxAllowedCost) {
            Log::warning("New cost exceeds maxAllowedCost, allowing update due to user intent", [
                'ServiceAvailedID' => $service['ServiceAvailedID'],
                'NewCost' => $newCost,
                'MaxAllowedCost' => $maxAllowedCost,
            ]);
            // Allow the update if explicitly requested
        }
    }
}
if (abs($newCost - $originalCost) > 0.01) {
    DB::table('services_availed')
        ->where('ServiceAvailedID', $service['ServiceAvailedID'])
        ->update(['UpdatedPrice' => $newCost]);
} else {
    DB::table('services_availed')
        ->where('ServiceAvailedID', $service['ServiceAvailedID'])
        ->update(['UpdatedPrice' => null]);
}
        }

        // Process services
        $totalAmount = $request->input('TotalAmount');
        $discount = $request->input('Discount');
        $totalChange = 0;
        $adjustedAmountPaid = 0;

        // Adjust AmountPaid for insurance services if not approved (unchanged)
        $updatedServices = collect($request->input('services'))->map(function ($service) use ($request, $activeTab) {
            $method = DB::table('payment_methods')
                ->where('MethodName', $service['PaymentMethod'])
                ->first();
            $isInsurance = $method && $method->MethodType === 'Insurance';
            return $service;
        })->all();

        // Separate insurance and non-insurance services (unchanged)
        $nonInsuranceServices = collect($updatedServices)->filter(function ($service) {
            $method = DB::table('payment_methods')->where('MethodName', $service['PaymentMethod'])->first();
            return !$method || $method->MethodType !== 'Insurance';
        })->all();

        $insuranceServices = collect($updatedServices)->filter(function ($service) {
            $method = DB::table('payment_methods')->where('MethodName', $service['PaymentMethod'])->first();
            return $method && $method->MethodType === 'Insurance';
        })->all();

        // Process non-insurance services (group by PaymentMethodID and ReferenceID)
        $groupedNonInsuranceServices = collect($nonInsuranceServices)->groupBy(function ($service) {
            $method = DB::table('payment_methods')
                ->where('MethodName', $service['PaymentMethod'])
                ->first();
            $paymentMethodId = $method ? $method->PaymentMethodID : 'N/A';
            $referenceId = $service['ReferenceID'] ?? 'NULL';
            return $paymentMethodId . '|' . $referenceId;
        });

        foreach ($groupedNonInsuranceServices as $groupKey => $group) {
            $groupServices = collect($group);
            $firstService = $groupServices->first();

            $method = DB::table('payment_methods')
                ->where('MethodName', $firstService['PaymentMethod'])
                ->first();

            if (!$method || $firstService['PaymentMethod'] === 'N/A') {
                Log::warning("Skipping payment creation for non-insurance group due to invalid payment method", [
                    'GroupKey' => $groupKey,
                    'PaymentMethod' => $firstService['PaymentMethod'],
                ]);
                continue;
            }

            // Sum the AmountPaid and Change for the group
            $groupAmountPaid = $groupServices->sum(function ($service) {
                return floatval($service['AmountPaid']);
            });
            $groupChange = $groupServices->sum(function ($service) {
                return floatval($service['Change']);
            });

            if ($groupAmountPaid <= 0) {
                Log::info("Skipping payment creation for non-insurance group with zero AmountPaid", [
                    'GroupKey' => $groupKey,
                    'AmountPaid' => $groupAmountPaid,
                ]);
                continue;
            }

            $referenceID = $firstService['ReferenceID'] ?? null;

            // Check if a payment with this PaymentMethodID already exists for the billing
            $existingPayment = Payment::where('BillingID', $billing->BillingID)
                ->where('PaymentMethodID', $method->PaymentMethodID)
                ->where('ReferenceID', $referenceID)
                ->first();

            if ($existingPayment) {
                // Only update if the new AmountPaid differs significantly (e.g., > 0.01)
                if (abs(floatval($existingPayment->AmountPaid) - $groupAmountPaid) > 0.01) {
                    $existingPayment->update([
                        'AmountPaid' => $groupAmountPaid,
                        'PaymentDate' => $groupAmountPaid > 0 ? now() : $existingPayment->PaymentDate,
                        'Change' => $groupChange,
                        'ReferenceID' => $referenceID ?? $existingPayment->ReferenceID,
                        'ProcessedBy' => Auth::user()->UserID,
                    ]);
                    Log::info("Updated existing payment", [
                        'PaymentID' => $existingPayment->PaymentID,
                        'NewAmountPaid' => $groupAmountPaid,
                    ]);
                } else {
                    Log::info("Skipped update: AmountPaid unchanged", [
                        'PaymentID' => $existingPayment->PaymentID,
                        'ExistingAmountPaid' => $existingPayment->AmountPaid,
                        'NewAmountPaid' => $groupAmountPaid,
                    ]);
                }
            } else {
                // Create a new payment
                Payment::create([
                    'BillingID' => $billing->BillingID,
                    'PatientID' => $patientId,
                    'PaymentMethodID' => $method->PaymentMethodID,
                    'AmountPaid' => $groupAmountPaid,
                    'PaymentDate' => $groupAmountPaid > 0 ? now() : null,
                    'Change' => $groupChange,
                    'ReferenceID' => $referenceID,
                    'ProcessedBy' => Auth::user()->UserID,
                ]);
                Log::info("Created new payment", [
                    'BillingID' => $billing->BillingID,
                    'AmountPaid' => $groupAmountPaid,
                ]);
            }

            $totalChange += $groupChange;
            $adjustedAmountPaid += $groupAmountPaid;
        }

        // Process insurance services individually
        foreach ($insuranceServices as $service) {
            $method = DB::table('payment_methods')
                ->where('MethodName', $service['PaymentMethod'])
                ->first();

            if (!$method || $service['PaymentMethod'] === 'N/A') {
                Log::warning("Skipping payment creation for insurance service due to invalid payment method", [
                    'ServiceAvailedID' => $service['ServiceAvailedID'],
                    'PaymentMethod' => $service['PaymentMethod'],
                ]);
                continue;
            }

            $methodType = $method->MethodType;
            $isInsuranceMethod = $methodType === 'Insurance' && in_array($method->MethodName, ['Medicard', 'Maxicare']);
            $serviceAmountPaid = floatval($service['AmountPaid']);
            $serviceChange = floatval($service['Change']);

            if ($serviceAmountPaid <= 0 && !$isInsuranceMethod) {
                Log::info("Skipping payment creation for insurance service with zero AmountPaid", [
                    'ServiceAvailedID' => $service['ServiceAvailedID'],
                    'AmountPaid' => $serviceAmountPaid,
                ]);
                continue;
            }

            $referenceID = $service['ReferenceID'] ?? null;
            $approvalCode = $isInsuranceMethod && $activeTab === 'insurance' ? $request->input('ApprovalCode') : null;
            $loe = $isInsuranceMethod && $method->MethodName === 'Maxicare' && $activeTab === 'insurance' ? $request->input('LOE') : null;

            // Check if a payment with this PaymentMethodID already exists for the billing
            $existingPayment = Payment::where('BillingID', $billing->BillingID)
                ->where('PaymentMethodID', $method->PaymentMethodID)
                ->first();

            if ($existingPayment) {
                // Only update if the new AmountPaid differs significantly (e.g., > 0.01)
                if (abs(floatval($existingPayment->AmountPaid) - $serviceAmountPaid) > 0.01) {
                    $existingPayment->update([
                        'AmountPaid' => $serviceAmountPaid,
                        'PaymentDate' => $isInsuranceMethod || $serviceAmountPaid > 0 ? now() : null,
                        'Change' => $serviceChange,
                        'ReferenceID' => $referenceID ?? $existingPayment->ReferenceID,
                        'ApprovalCode' => $approvalCode ?? $existingPayment->ApprovalCode,
                        'LOE' => $loe ?? $existingPayment->LOE,
                        'ProcessedBy' => Auth::user()->UserID,
                    ]);
                    Log::info("Updated existing insurance payment", [
                        'PaymentID' => $existingPayment->PaymentID,
                        'NewAmountPaid' => $serviceAmountPaid,
                    ]);
                } else {
                    Log::info("Skipped update: AmountPaid unchanged", [
                        'PaymentID' => $existingPayment->PaymentID,
                        'ExistingAmountPaid' => $existingPayment->AmountPaid,
                        'NewAmountPaid' => $serviceAmountPaid,
                    ]);
                }
            } else {
                // Create a new payment
                Payment::create([
                    'BillingID' => $billing->BillingID,
                    'PatientID' => $patientId,
                    'PaymentMethodID' => $method->PaymentMethodID,
                    'AmountPaid' => $serviceAmountPaid,
                    'PaymentDate' => $serviceAmountPaid > 0 ? now() : null,
                    'Change' => $serviceChange,
                    'ReferenceID' => $referenceID,
                    'ApprovalCode' => $approvalCode,
                    'LOE' => $loe,
                    'ProcessedBy' => Auth::user()->UserID,
                ]);
                Log::info("Created new insurance payment", [
                    'BillingID' => $billing->BillingID,
                    'ServiceAvailedID' => $service['ServiceAvailedID'],
                    'AmountPaid' => $serviceAmountPaid,
                ]);
            }

            $totalChange += $serviceChange;
            $adjustedAmountPaid += $serviceAmountPaid;
        }

        // Recalculate totals from all payments
        $allPayments = Payment::where('BillingID', $billing->BillingID)->get();
        $totalAmountPaidFromPayments = $allPayments->sum('AmountPaid');
        $totalChangeFromPayments = $allPayments->sum('Change');

        // Use billing's original TotalAmount unless explicitly updated in request
        $effectiveTotalAmount = $request->input('TotalAmount') !== $billing->TotalAmount ? $request->input('TotalAmount') : $billing->TotalAmount;
        $effectiveAmountPaid = $isInsurancePrimary && $totalAmountPaid > 0 && $request->input('ApprovalCode') && $activeTab === 'insurance'
            ? $totalAmountPaid
            : $totalAmountPaidFromPayments;
        $balance = max(0, $effectiveTotalAmount - $discount - $effectiveAmountPaid);

        // Update the billings table with corrected BillingStatus logic
        $billing->update([
            'TotalAmount' => $effectiveTotalAmount,
            'Discount' => $discount,
            'Balance' => $balance,
            'BillingStatus' => $balance == 0 ? 'Paid' : ($effectiveAmountPaid > 0 ? 'Partially Paid' : 'Unpaid'),
            'Remarks' => $request->input('Remarks'),
        ]);

        DB::commit();

        $billing->refresh();
        $billing->load('payments.paymentMethod');

        // Prepare response with service-level details (unchanged)
        $servicesResponse = collect($updatedServices)->map(function ($service) use ($servicesAvailed) {
            $sa = $servicesAvailed->firstWhere('ServiceAvailedID', $service['ServiceAvailedID']);
            $serviceCost = floatval($service['Cost']); // Use the updated cost
            $amountPaid = floatval($service['AmountPaid']);
            $paymentMethod = $service['PaymentMethod'];
            $method = DB::table('payment_methods')->where('MethodName', $paymentMethod)->first();
            $isInsurance = $method && $method->MethodType === 'Insurance';

            $paymentStatus = $amountPaid >= $serviceCost ? 'Paid' : ($amountPaid > 0 ? 'Partially Paid' : 'Unpaid');
            $tableCategory = $isInsurance ? 'insurance' : ($paymentStatus === 'Paid' ? 'paid' : 'unpaid');

            return [
                'ServiceAvailedID' => $sa->ServiceAvailedID,
                'ServiceName' => $sa->service->ServiceName,
                'Cost' => floatval($sa->service->Cost), // Original cost
                'UpdatedPrice' => $serviceCost, // Updated cost
                'AmountPaid' => $amountPaid,
                'Balance' => floatval($serviceCost - $amountPaid),
                'PaymentStatus' => $paymentStatus,
                'PaymentMethod' => $paymentMethod,
                'ReferenceID' => $service['ReferenceID'] ?? null,
                'Change' => floatval($service['Change']),
                'TableCategory' => $tableCategory,
            ];
        })->all();

        $response = [
            'BillingID' => $billing->BillingID,
            'AppointmentID' => $billing->AppointmentID,
            'TotalAmount' => floatval($billing->TotalAmount),
            'Discount' => floatval($billing->Discount),
            'Balance' => floatval($billing->Balance),
            'BillingStatus' => $billing->BillingStatus,
            'AmountPaid' => floatval($effectiveAmountPaid),
            'PaymentMethod' => $primaryPaymentMethod,
            'ReferenceID' => $request->input('ReferenceID'),
            'Change' => floatval($totalChange),
            'Remarks' => $billing->Remarks,
            'ApprovalCode' => $request->input('ApprovalCode'),
            'LOE' => $request->input('LOE'),
            'services' => $servicesResponse,
        ];

        Log::info("Billing updated successfully", ['response' => $response]);
        return response()->json(['billing' => $response]);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Error updating billing: " . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
        return response()->json(['message' => 'Failed to update billing: ' . $e->getMessage()], 500);
    }
}

    public function approveInsuranceBillings(Request $request)
    {
        Log::info("approveInsuranceBillings called", ['request' => $request->all()]);
    
        $billingIds = $request->input('billingIds', []);
        $approvalCode = $request->input('ApprovalCode');
        $loe = $request->input('LOE');
    
        $billings = Billing::whereIn('BillingID', $billingIds)->get();
        $hasMedicard = false;
        $hasMaxicare = false;
    
        foreach ($billings as $billing) {
            $services = DB::table('services_availed')
                ->where('BillingID', $billing->BillingID)
                ->get();
            foreach ($services as $service) {
                $paymentMethod = DB::table('payment_methods')
                    ->where('MethodName', $service->PaymentMethod)
                    ->first();
                if ($paymentMethod && $paymentMethod->MethodName === 'Medicard') {
                    $hasMedicard = true;
                } elseif ($paymentMethod && $paymentMethod->MethodName === 'Maxicare') {
                    $hasMaxicare = true;
                }
            }
        }
    
        if (!$approvalCode) {
            return response()->json(['message' => 'Approval Code is required'], 422);
        }
    
        if ($hasMedicard) {
            if (!preg_match('/^[A-Z]{2}\s\d{5,7}$/', $approvalCode)) {
                return response()->json(['message' => 'Approval Code for Medicard must be 2 letters, a space, then 5-7 digits (e.g., AB 12345)'], 422);
            }
        }
    
        if ($hasMaxicare) {
            if (!preg_match('/^\d{8,9}$/', $approvalCode)) {
                return response()->json(['message' => 'Approval Code for Maxicare must be 8-9 digits (e.g., 123456789)'], 422);
            }
            if (!$loe) {
                return response()->json(['message' => 'LOE # is required for Maxicare'], 422);
            }
            if (!preg_match('/^\d{8,9}$/', $loe)) {
                return response()->json(['message' => 'LOE # for Maxicare must be 8-9 digits (e.g., 987654321)'], 422);
            }
        }
    
        try {
            $totalApprovedAmount = 0;
            $approvedCount = 0;
    
            if (empty($billingIds)) {
                $billings = Billing::whereHas('payments', function ($query) {
                    $query->whereHas('paymentMethod', function ($q) {
                        $q->where('MethodType', 'Insurance');
                    })->where('AmountPaid', 0);
                })->where('BillingStatus', 'Unpaid')->get();
            } else {
                $billings = Billing::whereIn('BillingID', $billingIds)
                    ->where('BillingStatus', 'Unpaid')
                    ->whereHas('payments', function ($query) {
                        $query->whereHas('paymentMethod', function ($q) {
                            $q->where('MethodType', 'Insurance');
                        });
                    })
                    ->get();
            }
    
            foreach ($billings as $billing) {
                $services = DB::table('services_availed')
                    ->where('BillingID', $billing->BillingID)
                    ->where('PaymentMethod', 'Medicard')  // Adjust based on actual insurance provider
                    ->get();
                if ($services->isEmpty()) {
                    continue;
                }
    
                $payment = Payment::where('BillingID', $billing->BillingID)
                    ->whereHas('paymentMethod', function ($q) {
                        $q->where('MethodType', 'Insurance');
                    })
                    ->first();
    
                if (!$payment) {
                    // Create a new payment record for insurance
                    $paymentMethod = DB::table('payment_methods')
                        ->where('MethodName', 'Medicard')  // Adjust based on actual insurance provider
                        ->first();
                    $payment = Payment::create([
                        'BillingID' => $billing->BillingID,
                        'PatientID' => $billing->appointment->PatientID,
                        'PaymentMethodID' => $paymentMethod->PaymentMethodID,
                        'AmountPaid' => 0,
                        'Change' => 0,
                    ]);
                }
    
                if ($payment && $payment->AmountPaid == 0) {
                    $payableAmount = $billing->TotalAmount - ($billing->Discount ?? 0);
                    $payment->AmountPaid = $payableAmount;
                    $payment->PaymentDate = now();
                    $payment->ApprovalCode = $approvalCode;
                    $payment->LOE = $hasMaxicare ? $loe : null;
                    $payment->save();
    
                    $billing->BillingStatus = 'Paid';
                    $billing->Balance = 0;
                    $billing->save();
    
                    foreach ($services as $service) {
                        DB::table('services_availed')
                            ->where('ServiceAvailedID', $service->ServiceAvailedID)
                            ->update(['PaymentStatus' => 'Paid']);
                    }
    
                    $totalApprovedAmount += $payment->AmountPaid;
                    $approvedCount++;
                }
            }
    
            return response()->json([
                'message' => "$approvedCount insurance billings approved successfully",
                'count' => $approvedCount,
                'totalApprovedAmount' => $totalApprovedAmount,
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error approving insurance billings: {$e->getMessage()}", ['exception' => $e]);
            return response()->json(['message' => 'Failed to approve insurance billings: ' . $e->getMessage()], 500);
        }
    }    

    public function declineInsuranceBilling(Request $request, $billingId)
    {
        try {
            DB::beginTransaction();

            // Fetch the original TotalAmount from services via services_availed
            $totalAmount = DB::table('billings')
                ->join('services_availed', 'billings.AppointmentID', '=', 'services_availed.AppointmentID')
                ->join('services', 'services_availed.ServiceID', '=', 'services.ServiceID')
                ->where('billings.BillingID', $billingId)
                ->sum('services.Cost');

            // Update the billings table
            DB::table('billings')
                ->where('BillingID', $billingId)
                ->update([
                    'BillingStatus' => 'Unpaid',
                    'TotalAmount' => $totalAmount,
                    'Balance' => $totalAmount,
                    'Remarks' => $request->Remarks ?? null,
                    'updated_at' => now(),
                ]);

            // Delete associated payment records
            DB::table('payments')
                ->where('BillingID', $billingId)
                ->delete();

            // Update services_availed (optional, confirm if needed)
            DB::table('services_availed')
                ->join('billings', 'services_availed.AppointmentID', '=', 'billings.AppointmentID')
                ->where('billings.BillingID', $billingId)
                ->update([
                    'services_availed.Status' => 'Cancelled',
                    'services_availed.updated_at' => now(),
                ]);

            DB::commit();

            return response()->json(['message' => 'Insurance billing declined successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error declining insurance billing: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to decline insurance billing'], 500);
        }
    }

    public function getMultiVisitBilling(Request $request, $patientId, $procedure)
    {
        Log::info("Fetching multi-visit billing for PatientID: $patientId, Procedure: $procedure");

        $treatmentProgress = TreatmentProgress::where('PatientID', $patientId)
            ->where('TreatmentName', $procedure)
            ->where('Status', 'In Progress')
            ->first();

        if (!$treatmentProgress) {
            Log::info("No in-progress treatment found for PatientID: $patientId, Procedure: $procedure");
            return response()->json(null, 200);
        }

        $billing = Billing::whereHas('appointment.servicesAvailed', function ($query) use ($treatmentProgress) {
            $query->where('TreatmentProgressID', $treatmentProgress->TreatmentProgressID);
        })->where('BillingStatus', '!=', 'Paid')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($billing) {
            $payments = $billing->payments->sum('AmountPaid');
            $response = [
                'BillingID' => $billing->BillingID,
                'AppointmentID' => $billing->AppointmentID,
                'TotalAmount' => floatval($billing->TotalAmount),
                'Discount' => floatval($billing->Discount),
                'Balance' => floatval($billing->Balance),
                'BillingStatus' => $billing->BillingStatus,
                'AmountPaid' => floatval($payments),
            ];
            Log::info("Returning existing multi-visit billing", ['billing' => $response]);
            return response()->json($response);
        }

        return response()->json(null, 200);
    }

    public function getPaymentMethods()
    {
        $paymentMethods = DB::table('payment_methods')
            ->where('IsActive', 1)
            ->select('MethodName', 'MethodType')
            ->get();
        Log::info("Fetched payment methods", ['paymentMethods' => $paymentMethods->toArray()]);
        return response()->json($paymentMethods);
    }

    public function getServiceCost($appointmentId)
    {
        $cost = Appointment::find($appointmentId)
            ->servicesAvailed()
            ->with('service')
            ->first()
            ->service->Cost ?? 0;
        return response()->json(['Cost' => floatval($cost)]);
    }

    public function getPatientBillings(Request $request)
    {
        Log::info("Fetching billings for authenticated patient");
    
        $user = Auth::user();
        if (!$user) {
            Log::error("No authenticated user found");
            return response()->json(['message' => 'Unauthorized: No user authenticated'], 401);
        }
    
        $patient = $user->patient;
        if (!$patient) {
            Log::error("No patient profile found for user", ['user_id' => $user->UserID]);
            return response()->json(['message' => 'Unauthorized: No patient profile found'], 403);
        }
    
        $patientId = $patient->PatientID;
        Log::info("Authenticated patient ID", ['patient_id' => $patientId]);
    
        $billings = Billing::with([
            'appointment' => function ($query) use ($patientId) {
                $query->where('PatientID', $patientId)
                      ->with(['patient.user', 'dentist.user', 'servicesAvailed.service']);
            },
            'payments.paymentMethod'
        ])
        ->whereHas('appointment', function ($query) use ($patientId) {
            $query->where('PatientID', $patientId);
        })
        ->get();
    
        Log::info("Raw billings fetched", ['billings_count' => $billings->count()]);
    
        $billings = $billings->map(function ($billing) {
            $appointment = $billing->appointment;
            $servicesAvailed = $appointment ? $appointment->servicesAvailed : collect();
    
            $displayServices = $appointment && strtolower($appointment->AppointmentStatus) === 'completed'
                ? $servicesAvailed
                : $servicesAvailed->filter(function ($sa) {
                    return $sa->Status === 'Completed';
                });
    
            $services = $displayServices->map(function ($sa) {
                return [
                    'ServiceName' => $sa->service->ServiceName,
                    'IsMultiVisit' => $sa->service->IsMultiVisit,
                    'ServicesAvailedID' => $sa->ServiceAvailedID,
                    'TreatmentProgressID' => $sa->TreatmentProgressID,
                ];
            })->all();
    
            $procedure = !empty($services) ? collect($services)->pluck('ServiceName')->implode(', ') : 'No services';
            $payments = $billing->payments->isNotEmpty() ? $billing->payments->sum('AmountPaid') : 0;
            $latestPayment = $billing->payments->isNotEmpty() ? $billing->payments->sortByDesc('PaymentDate')->first() : null;
    
            $paymentMethod = 'N/A';
            $change = 0;
            $referenceId = null;
            $paymentDate = null;
    
            if ($billing->Balance == 0 && $payments == 0) {
                $treatmentProgressId = !empty($services) ? collect($services)->pluck('TreatmentProgressID')->first() : null;
                if ($treatmentProgressId) {
                    $latestPaymentForTreatment = Payment::whereHas('billing.appointment.servicesAvailed', function ($query) use ($treatmentProgressId) {
                        $query->where('TreatmentProgressID', $treatmentProgressId);
                    })
                    ->with('paymentMethod')
                    ->orderBy('PaymentDate', 'desc')
                    ->first();
    
                    if ($latestPaymentForTreatment && $latestPaymentForTreatment->paymentMethod) {
                        $paymentMethod = $latestPaymentForTreatment->paymentMethod->MethodName;
                        $change = $latestPaymentForTreatment->Change ?? 0;
                        $referenceId = $latestPaymentForTreatment->ReferenceID ?? null;
                        $paymentDate = $latestPaymentForTreatment->PaymentDate ? $latestPaymentForTreatment->PaymentDate->toDateTimeString() : null;
                    }
                }
            } elseif ($latestPayment && $latestPayment->paymentMethod && $payments > 0) {
                $paymentMethod = $latestPayment->paymentMethod->MethodName;
                $change = $latestPayment->Change ?? 0;
                $referenceId = $latestPayment->ReferenceID ?? null;
                $paymentDate = $latestPayment->PaymentDate ? $latestPayment->PaymentDate->toDateTimeString() : null;
            }
    
            $completionDate = $appointment
                ? ($appointment->AppointmentDate . ' ' . $appointment->AppointmentTime)
                : $billing->updated_at->toDateTimeString();
    
            return [
                'BillingID' => $billing->BillingID,
                'AppointmentID' => $billing->AppointmentID,
                'PatientID' => $appointment ? $appointment->PatientID : null,
                'PatientName' => $appointment && $appointment->patient && $appointment->patient->user
                    ? $appointment->patient->user->FirstName . ' ' . $appointment->patient->user->LastName
                    : 'N/A',
                'AppointmentDateTime' => $appointment
                    ? $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime
                    : 'N/A',
                'AssignedDentist' => $appointment && $appointment->dentist && $appointment->dentist->user
                    ? $appointment->dentist->user->FirstName . ' ' . $appointment->dentist->user->LastName
                    : 'N/A',
                'Procedure' => $procedure,
                'TotalAmount' => floatval($billing->TotalAmount),
                'Discount' => floatval($billing->Discount),
                'Balance' => floatval($billing->Balance),
                'BillingStatus' => $billing->BillingStatus,
                'PaymentMethod' => $paymentMethod,
                'AmountPaid' => floatval($payments),
                'PaymentDate' => $paymentDate ?? $billing->updated_at->toDateTimeString(), // Fallback to updated_at
                'CompletionDate' => (new DateTime($completionDate))->format('Y-m-d H:i:s'),
                'Change' => floatval($change),
                'ReferenceID' => $referenceId,
            ];
        });
    
        Log::info("Returning patient billings", ['billings' => $billings->toArray()]);
        return response()->json($billings);
    }

    // Transaction Date/Time Based
    public function getPatientLedger(Request $request, $patientId = null, $returnBalanceOnly = false)
    {
        Log::info("Fetching ledger for PatientID: $patientId");

        if (!$patientId) {
            $user = Auth::user();
            if (!$user) {
                Log::error("No authenticated user found");
                return response()->json(['message' => 'Unauthorized: No user authenticated'], 401);
            }

            $patient = $user->patient;
            if (!$patient) {
                Log::error("No patient profile found for user", ['user_id' => $user->UserID]);
                return response()->json(['message' => 'Unauthorized: No patient profile found'], 403);
            }

            $patientId = $patient->PatientID;
            Log::info("Using authenticated patient ID", ['patient_id' => $patientId]);
        }

        try {
            $appointments = Appointment::where('PatientID', $patientId)
                ->where('AppointmentStatus', 'Completed')
                ->with([
                    'servicesAvailed.service',
                    'servicesAvailed.treatmentProgress',
                    'billing.payments.paymentMethod'
                ])
                ->get();

            $treatmentProgresses = TreatmentProgress::where('PatientID', $patientId)
                ->get()
                ->keyBy('TreatmentProgressID');

            $standalonePayments = Payment::where('PatientID', $patientId)
                ->whereNull('BillingID')
                ->with('paymentMethod')
                ->get();

            $ledgerEntries = [];
            $runningBalance = 0;
            $processedTreatments = []; // Track processed multi-visit treatments
            $treatmentBalances = []; // Track remaining balance per TreatmentProgressID

            foreach ($appointments as $appointment) {
                $baseTransactionDate = $appointment->updated_at
                    ? $appointment->updated_at->toDateTimeString()
                    : now()->toDateTimeString();

                Log::info("Using updated_at as base transaction date for completed appointment", [
                    'AppointmentID' => $appointment->AppointmentID,
                    'BaseTransactionDate' => $baseTransactionDate,
                ]);

                $servicesAvailed = $appointment->servicesAvailed;

                foreach ($servicesAvailed as $serviceAvailed) {
                    if (!$serviceAvailed->service) {
                        Log::warning("Skipping service availed due to missing service", [
                            'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
                        ]);
                        continue;
                    }

                    $serviceCost = $serviceAvailed->UpdatedPrice ?? $serviceAvailed->service->Cost;
                    $serviceCost = floatval($serviceCost);

                    if ($serviceAvailed->service->IsMultiVisit && $serviceAvailed->treatmentProgress) {
                        $treatmentProgress = $serviceAvailed->treatmentProgress;
                        $treatmentProgressId = $treatmentProgress->TreatmentProgressID;

                        // Initialize balance for this treatment if not set
                        if (!isset($treatmentBalances[$treatmentProgressId])) {
                            $treatmentBalances[$treatmentProgressId] = 0;
                        }

                        // Calculate prior balance and check for price change
                        $priorBalance = $treatmentBalances[$treatmentProgressId];
                        $priceDifference = $serviceCost - $priorBalance;

                        // Only add a debit entry if it's the first visit or if the price has changed
                        if (!isset($processedTreatments[$treatmentProgressId]) || abs($priceDifference) > 0.01) {
                            $debitAmount = isset($processedTreatments[$treatmentProgressId]) ? $priceDifference : $serviceCost;

                            $ledgerEntries[] = [
                                'Service' => $serviceAvailed->service->ServiceName . ' (Visit ' . $treatmentProgress->VisitCount . ')',
                                'PaymentMethod' => null,
                                'TransactionDate' => $baseTransactionDate,
                                'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Treatment #' . $treatmentProgressId . ')',
                                'Debit' => $debitAmount,
                                'Credit' => 0,
                                'Balance' => $runningBalance += $debitAmount,
                                'IsStandalonePayment' => false,
                                'TreatmentProgressID' => $treatmentProgressId,
                                'Remarks' => $appointment->billing ? ($appointment->billing->Remarks ?? '') : '',
                            ];

                            // Update the treatment balance to the new service cost
                            $treatmentBalances[$treatmentProgressId] = $serviceCost;

                            Log::info("Added debit entry for multi-visit service", [
                                'TreatmentProgressID' => $treatmentProgressId,
                                'ServiceName' => $serviceAvailed->service->ServiceName,
                                'VisitCount' => $treatmentProgress->VisitCount,
                                'Debit' => $debitAmount,
                                'PriorBalance' => $priorBalance,
                                'NewBalance' => $serviceCost,
                            ]);

                            $processedTreatments[$treatmentProgressId] = [
                                'ServiceID' => $serviceAvailed->service->ServiceID,
                                'Status' => $treatmentProgress->Status,
                            ];
                        } else {
                            Log::info("Skipped debit entry for multi-visit service; no price change", [
                                'TreatmentProgressID' => $treatmentProgressId,
                                'ServiceName' => $serviceAvailed->service->ServiceName,
                                'VisitCount' => $treatmentProgress->VisitCount,
                                'CurrentCost' => $serviceCost,
                                'PriorBalance' => $priorBalance,
                            ]);
                        }
                    } else {
                        $ledgerEntries[] = [
                            'Service' => $serviceAvailed->service->ServiceName,
                            'PaymentMethod' => null,
                            'TransactionDate' => $baseTransactionDate,
                            'Reference' => 'Appointment #' . $appointment->AppointmentID,
                            'Debit' => $serviceCost,
                            'Credit' => 0,
                            'Balance' => $runningBalance += $serviceCost,
                            'IsStandalonePayment' => false,
                            'Remarks' => $appointment->billing ? ($appointment->billing->Remarks ?? '') : '',
                        ];
                    }
                }

                if ($appointment->billing) {
                    $billing = $appointment->billing;
                    $billingDate = $billing->updated_at
                        ? $billing->updated_at->toDateTimeString()
                        : $baseTransactionDate;
                    $transactionDate = strtotime($billingDate) > strtotime($baseTransactionDate)
                        ? $billingDate
                        : $baseTransactionDate;

                    $discount = floatval($billing->Discount ?? 0);

                    if ($discount > 0) {
                        $ledgerEntries[] = [
                            'Service' => null,
                            'PaymentMethod' => 'Discount',
                            'TransactionDate' => $transactionDate,
                            'Reference' => 'Billing #' . $billing->BillingID,
                            'Debit' => 0,
                            'Credit' => $discount,
                            'Balance' => $runningBalance -= $discount,
                            'IsStandalonePayment' => false,
                            'Remarks' => $billing->Remarks ?? '',
                        ];
                    }

                    if ($billing->payments && $billing->payments->isNotEmpty()) {
                        foreach ($billing->payments as $payment) {
                            $paymentDate = $payment->PaymentDate
                                ? $payment->PaymentDate->toDateTimeString()
                                : $baseTransactionDate;
                            $paymentTransactionDate = strtotime($paymentDate) > strtotime($transactionDate)
                                ? $paymentDate
                                : date('Y-m-d H:i:s', strtotime($transactionDate . ' +1 minute'));

                            $methodName = $payment->paymentMethod
                                ? $payment->paymentMethod->MethodName
                                : 'Unknown Method';
                            $netAmountPaid = floatval($payment->AmountPaid) - floatval($payment->Change);

                            $ledgerEntries[] = [
                                'Service' => null,
                                'PaymentMethod' => $methodName,
                                'TransactionDate' => $paymentTransactionDate,
                                'Reference' => $payment->ReferenceID ?? 'Payment #' . $payment->PaymentID,
                                'Debit' => 0,
                                'Credit' => $netAmountPaid,
                                'Balance' => $runningBalance -= $netAmountPaid,
                                'IsStandalonePayment' => false,
                                'Remarks' => $billing->Remarks ?? '',
                            ];

                            // Update treatment balance for multi-visit services
                            foreach ($servicesAvailed as $sa) {
                                if ($sa->service->IsMultiVisit && $sa->treatmentProgress) {
                                    $treatmentProgressId = $sa->treatmentProgress->TreatmentProgressID;
                                    if (isset($treatmentBalances[$treatmentProgressId])) {
                                        $treatmentBalances[$treatmentProgressId] -= $netAmountPaid;
                                        Log::info("Updated treatment balance after payment", [
                                            'TreatmentProgressID' => $treatmentProgressId,
                                            'PaymentID' => $payment->PaymentID,
                                            'NetAmountPaid' => $netAmountPaid,
                                            'NewTreatmentBalance' => $treatmentBalances[$treatmentProgressId],
                                        ]);
                                    }
                                }
                            }

                            Log::info("Added billing payment to ledger", [
                                'PaymentID' => $payment->PaymentID,
                                'BillingID' => $billing->BillingID,
                                'AmountPaid' => $netAmountPaid,
                                'MethodName' => $methodName,
                                'TransactionDate' => $paymentTransactionDate,
                            ]);
                        }
                    }
                }
            }

            foreach ($standalonePayments as $payment) {
                $paymentDate = $payment->PaymentDate
                    ? $payment->PaymentDate->toDateTimeString()
                    : now()->toDateTimeString();
                $methodName = $payment->paymentMethod
                    ? $payment->paymentMethod->MethodName
                    : 'Unknown Method';
                $netAmountPaid = floatval($payment->AmountPaid) - floatval($payment->Change);

                $ledgerEntries[] = [
                    'Service' => 'Standalone Payment',
                    'PaymentMethod' => $methodName,
                    'TransactionDate' => $paymentDate,
                    'Reference' => $payment->ReferenceID ?? 'Payment #' . $payment->PaymentID,
                    'Debit' => 0,
                    'Credit' => $netAmountPaid,
                    'Balance' => $runningBalance -= $netAmountPaid,
                    'IsStandalonePayment' => true,
                    'Remarks' => $payment->Notes ?? '',
                ];

                // Apply standalone payment to multi-visit treatment balances
                foreach ($treatmentProgresses as $tp) {
                    if (isset($treatmentBalances[$tp->TreatmentProgressID]) && $treatmentBalances[$tp->TreatmentProgressID] > 0) {
                        $treatmentBalances[$tp->TreatmentProgressID] -= $netAmountPaid;
                        Log::info("Applied standalone payment to treatment balance", [
                            'TreatmentProgressID' => $tp->TreatmentProgressID,
                            'PaymentID' => $payment->PaymentID,
                            'NetAmountPaid' => $netAmountPaid,
                            'NewTreatmentBalance' => $treatmentBalances[$tp->TreatmentProgressID],
                        ]);
                        break; // Apply to the first unpaid multi-visit treatment
                    }
                }
            }

            foreach ($appointments as $appointment) {
                foreach ($appointment->servicesAvailed as $serviceAvailed) {
                    if (!$serviceAvailed->service || !$serviceAvailed->treatmentProgress) {
                        continue;
                    }

                    $service = $serviceAvailed->service;
                    if (!$service->IsMultiVisit) {
                        continue;
                    }

                    $treatmentProgress = $serviceAvailed->treatmentProgress;
                    $treatmentProgressId = $treatmentProgress->TreatmentProgressID;

                    if (isset($processedTreatments[$treatmentProgressId])) {
                        continue;
                    }

                    $previousTreatment = null;
                    foreach ($treatmentProgresses as $tp) {
                        if ($tp->TreatmentName === $service->ServiceName && $tp->PatientID == $patientId && $tp->Status === 'Completed') {
                            $previousTreatment = $tp;
                            break;
                        }
                    }

                    if ($previousTreatment) {
                        $baseTransactionDate = $appointment->updated_at
                            ? $appointment->updated_at->toDateTimeString()
                            : now()->toDateTimeString();
                        $serviceCost = $serviceAvailed->UpdatedPrice ?? $service->Cost;
                        $serviceCost = floatval($serviceCost);

                        $priorBalance = $treatmentBalances[$treatmentProgressId] ?? 0;
                        $priceDifference = $serviceCost - $priorBalance;

                        if (abs($priceDifference) > 0.01) {
                            $ledgerEntries[] = [
                                'Service' => $service->ServiceName . ' (Visit ' . $treatmentProgress->VisitCount . ')',
                                'PaymentMethod' => null,
                                'TransactionDate' => $baseTransactionDate,
                                'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Treatment #' . $treatmentProgressId . ')',
                                'Debit' => $priceDifference,
                                'Credit' => 0,
                                'Balance' => $runningBalance += $priceDifference,
                                'IsStandalonePayment' => false,
                                'Remarks' => $appointment->billing ? ($appointment->billing->Remarks ?? '') : '',
                            ];

                            $treatmentBalances[$treatmentProgressId] = $serviceCost;

                            $processedTreatments[$treatmentProgressId] = [
                                'ServiceID' => $service->ServiceID,
                                'Status' => $treatmentProgress->Status,
                            ];
                        }
                    }
                }
            }

            usort($ledgerEntries, function ($a, $b) {
                $dateA = strtotime($a['TransactionDate']) ?: 0;
                $dateB = strtotime($b['TransactionDate']) ?: 0;
                return $dateA <=> $dateB;
            });

            $runningBalance = 0;
            foreach ($ledgerEntries as &$entry) {
                $runningBalance = $runningBalance + $entry['Debit'] - $entry['Credit'];
                $entry['Balance'] = $runningBalance;
            }

            if ($returnBalanceOnly) {
                $finalBalance = $ledgerEntries ? end($ledgerEntries)['Balance'] : 0;
                Log::info("Returning balance for PatientID: $patientId", ['balance' => $finalBalance]);
                return $finalBalance;
            }

            Log::info("Returning ledger for PatientID: $patientId", ['entries' => $ledgerEntries]);
            return response()->json(['ledger' => $ledgerEntries]);
        } catch (\Exception $e) {
            Log::error("Error fetching ledger for PatientID: $patientId", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Failed to fetch ledger data'], 500);
        }
    }

    // public function getPatientLedger(Request $request, $patientId = null, $returnBalanceOnly = false)
    // {
    //     Log::info("Fetching ledger for PatientID: $patientId");

    //     // If no patientId is provided, use the authenticated patient's ID
    //     if (!$patientId) {
    //         $user = Auth::user();
    //         if (!$user) {
    //             Log::error("No authenticated user found");
    //             return response()->json(['message' => 'Unauthorized: No user authenticated'], 401);
    //         }

    //         $patient = $user->patient;
    //         if (!$patient) {
    //             Log::error("No patient profile found for user", ['user_id' => $user->UserID]);
    //             return response()->json(['message' => 'Unauthorized: No patient profile found'], 403);
    //         }

    //         $patientId = $patient->PatientID;
    //         Log::info("Using authenticated patient ID", ['patient_id' => $patientId]);
    //     }

    //     try {
    //         // Fetch all completed appointments for the patient
    //         $appointments = Appointment::where('PatientID', $patientId)
    //             ->where('AppointmentStatus', 'Completed')
    //             ->with([
    //                 'servicesAvailed.service',
    //                 'servicesAvailed.treatmentProgress',
    //                 'billing.payments.paymentMethod'
    //             ])
    //             ->get();

    //         // Fetch all treatment progress records for the patient to track multi-visit treatments
    //         $treatmentProgresses = TreatmentProgress::where('PatientID', $patientId)
    //             ->get()
    //             ->keyBy('TreatmentProgressID');

    //         // Fetch standalone payments (BillingID is null) for the patient
    //         $standalonePayments = Payment::where('PatientID', $patientId)
    //             ->whereNull('BillingID')
    //             ->with('paymentMethod')
    //             ->get();

    //         $ledgerEntries = [];
    //         $runningBalance = 0;
    //         $processedTreatments = []; // Track which multi-visit treatments have been debited

    //         // Process each completed appointment
    //         foreach ($appointments as $appointment) {
    //             $baseTransactionDate = $appointment->AppointmentDate instanceof DateTime
    //                 ? $appointment->AppointmentDate->toDateTimeString()
    //                 : ($appointment->updated_at instanceof DateTime
    //                     ? $appointment->updated_at->toDateTimeString()
    //                     : (new DateTime($appointment->AppointmentDate ?: $appointment->updated_at ?: now()))->toDateTimeString());

    //             Log::info("Using AppointmentDate as base transaction date for completed appointment", [
    //                 'AppointmentID' => $appointment->AppointmentID,
    //                 'BaseTransactionDate' => $baseTransactionDate,
    //             ]);

    //             $servicesAvailed = $appointment->servicesAvailed;
    //             $hasMultiVisitService = false;

    //             foreach ($servicesAvailed as $serviceAvailed) {
    //                 if (!$serviceAvailed->service) {
    //                     Log::warning("Skipping service availed due to missing service", [
    //                         'ServiceAvailedID' => $serviceAvailed->ServiceAvailedID,
    //                     ]);
    //                     continue;
    //                 }

    //                 $serviceCost = is_numeric($serviceAvailed->service->Cost) ? floatval($serviceAvailed->service->Cost) : 0;
    //                 if ($serviceAvailed->service->IsMultiVisit) {
    //                     $hasMultiVisitService = true;
    //                 }
    //             }

    //             foreach ($servicesAvailed as $serviceAvailed) {
    //                 if (!$serviceAvailed->service) continue;

    //                 $service = $serviceAvailed->service;
    //                 $serviceCost = is_numeric($service->Cost) ? floatval($service->Cost) : 0;
    //                 $updatedPrice = $serviceAvailed->UpdatedPrice !== null ? floatval($serviceAvailed->UpdatedPrice) : null;

    //                 if ($service->IsMultiVisit) {
    //                     if (!$serviceAvailed->treatmentProgress) {
    //                         continue;
    //                     }
    //                     $treatmentProgress = $serviceAvailed->treatmentProgress;
    //                     $treatmentProgressId = $treatmentProgress->TreatmentProgressID;

    //                     // Add debit entry for the service if not previously processed for this visit
    //                     if (!isset($processedTreatments[$treatmentProgressId]) || $treatmentProgress->VisitCount == 1) {
    //                         $ledgerEntries[] = [
    //                             'Service' => $service->ServiceName . ' (Visit ' . $treatmentProgress->VisitCount . ')',
    //                             'PaymentMethod' => null,
    //                             'TransactionDate' => $baseTransactionDate,
    //                             'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Treatment #' . $treatmentProgressId . ')',
    //                             'Debit' => $serviceCost,
    //                             'Credit' => 0,
    //                             'Balance' => $runningBalance += $serviceCost,
    //                             'IsStandalonePayment' => false,
    //                             'TreatmentProgressID' => $treatmentProgressId,
    //                         ];
    //                     }

    //                     $processedTreatments[$treatmentProgressId] = [
    //                         'ServiceID' => $service->ServiceID,
    //                         'Status' => $treatmentProgress->Status,
    //                     ];
    //                 } else {
    //                     $ledgerEntries[] = [
    //                         'Service' => $service->ServiceName,
    //                         'PaymentMethod' => null,
    //                         'TransactionDate' => $baseTransactionDate,
    //                         'Reference' => 'Appointment #' . $appointment->AppointmentID,
    //                         'Debit' => $serviceCost,
    //                         'Credit' => 0,
    //                         'Balance' => $runningBalance += $serviceCost,
    //                         'IsStandalonePayment' => false,
    //                     ];
    //                 }
    //             }

    //             if ($appointment->billing) {
    //                 $billing = $appointment->billing;
    //                 $billingDate = $billing->updated_at instanceof DateTime
    //                     ? $billing->updated_at->toDateTimeString()
    //                     : (new DateTime($billing->updated_at ?: now()))->toDateTimeString();
    //                 $transactionDate = $billingDate;

    //                 $discount = floatval($billing->Discount ?? 0);
    //                 $totalAmount = floatval($billing->TotalAmount);
    //                 $originalTotalAmount = $totalAmount;

    //                 // Adjust originalTotalAmount for multi-visit services based on prior balance
    //                 if ($hasMultiVisitService && $runningBalance > 0) {
    //                     $originalTotalAmount = $runningBalance;
    //                 }

    //                 if ($discount > 0) {
    //                     $ledgerEntries[] = [
    //                         'Service' => null,
    //                         'PaymentMethod' => 'Discount',
    //                         'TransactionDate' => $transactionDate,
    //                         'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Discount)',
    //                         'Debit' => 0,
    //                         'Credit' => $discount,
    //                         'Balance' => $runningBalance -= $discount,
    //                         'IsStandalonePayment' => false,
    //                     ];
    //                 }

    //                 // Handle adjustments (initial billing entry)
    //                 foreach ($servicesAvailed as $serviceAvailed) {
    //                     if (!$serviceAvailed->service || !$serviceAvailed->treatmentProgress) continue;
    //                     $service = $serviceAvailed->service;
    //                     $serviceCost = is_numeric($service->Cost) ? floatval($service->Cost) : 0;
    //                     $updatedPrice = $serviceAvailed->UpdatedPrice !== null ? floatval($serviceAvailed->UpdatedPrice) : null;

    //                     if ($service->IsMultiVisit && $updatedPrice === null && $totalAmount > 0) {
    //                         $updatedPrice = $totalAmount;
    //                         Log::warning("UpdatedPrice is null, falling back to TotalAmount", ['ServiceAvailedID' => $serviceAvailed->ServiceAvailedID, 'TotalAmount' => $totalAmount]);
    //                     }

    //                     $treatmentProgressId = $serviceAvailed->treatmentProgress->TreatmentProgressID;

    //                     if ($service->IsMultiVisit && $updatedPrice !== null && abs($updatedPrice - $originalTotalAmount) > 0.01) {
    //                         $adjustmentAmount = $updatedPrice - $originalTotalAmount;
    //                         $adjustmentDate = date('Y-m-d H:i:s', strtotime($transactionDate . ' +1 minute'));
    //                         $ledgerEntries[] = [
    //                             'Service' => null,
    //                             'PaymentMethod' => 'Adjustment',
    //                             'TransactionDate' => $adjustmentDate,
    //                             'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Adjustment for Treatment #' . $treatmentProgressId . ')',
    //                             'Debit' => $adjustmentAmount > 0 ? $adjustmentAmount : 0,
    //                             'Credit' => $adjustmentAmount < 0 ? abs($adjustmentAmount) : 0,
    //                             'Balance' => $runningBalance += $adjustmentAmount,
    //                             'IsStandalonePayment' => false,
    //                             'TreatmentProgressID' => $treatmentProgressId,
    //                         ];

    //                         Log::info("Added price adjustment based on originalTotalAmount", [
    //                             'TreatmentProgressID' => $treatmentProgressId,
    //                             'ServiceName' => $service->ServiceName,
    //                             'OriginalTotalAmount' => $originalTotalAmount,
    //                             'UpdatedPrice' => $updatedPrice,
    //                             'AdjustmentAmount' => $adjustmentAmount,
    //                             'TransactionDate' => $adjustmentDate,
    //                         ]);
    //                     }
    //                 }

    //                 if (!$hasMultiVisitService) {
    //                     $totalOriginalServiceCost = $servicesAvailed->sum(function ($sa) {
    //                         return is_numeric($sa->service->Cost) ? floatval($sa->service->Cost) : 0;
    //                     });
    //                     $adjustmentAmount = $totalOriginalServiceCost - $totalAmount;

    //                     if (abs($adjustmentAmount) > 0.01) {
    //                         $adjustmentDate = date('Y-m-d H:i:s', strtotime($transactionDate . ' +1 minute'));
    //                         $ledgerEntries[] = [
    //                             'Service' => null,
    //                             'PaymentMethod' => 'Adjustment',
    //                             'TransactionDate' => $adjustmentDate,
    //                             'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Adjustment)',
    //                             'Debit' => $adjustmentAmount < 0 ? abs($adjustmentAmount) : 0,
    //                             'Credit' => $adjustmentAmount > 0 ? $adjustmentAmount : 0,
    //                             'Balance' => $runningBalance += ($adjustmentAmount < 0 ? -abs($adjustmentAmount) : $adjustmentAmount),
    //                             'IsStandalonePayment' => false,
    //                         ];
    //                     }
    //                 }

    //                 // Handle payments (initial entry with 0 credit if pending approval)
    //                 if ($billing->payments) {
    //                     foreach ($billing->payments as $payment) {
    //                         $paymentDate = $payment->PaymentDate instanceof DateTime
    //                             ? $payment->PaymentDate->toDateTimeString()
    //                             : (new DateTime($payment->PaymentDate ?: ($billing->updated_at ?: now())))->toDateTimeString();
    //                         $methodName = $payment->paymentMethod
    //                             ? $payment->paymentMethod->MethodName
    //                             : 'Unknown Method';
    //                         $netAmountPaid = floatval($payment->AmountPaid) - floatval($payment->Change);
    //                         $isInsurance = $methodName === 'Insurance'; // Assume 'Insurance' indicates insurance payment
    //                         $creditAmount = $isInsurance && !$payment->ApprovalCode ? 0 : $netAmountPaid; // 0 credit until approval

    //                         $paymentTransactionDate = date('Y-m-d H:i:s', strtotime($paymentDate . ' +2 minutes'));
    //                         $ledgerEntries[] = [
    //                             'Service' => null,
    //                             'PaymentMethod' => $methodName,
    //                             'TransactionDate' => $paymentTransactionDate,
    //                             'Reference' => 'Appointment #' . $appointment->AppointmentID . ' (Payment #' . $payment->PaymentID . ($isInsurance && !$payment->ApprovalCode ? ' - Pending Approval' : '' ) . ')',
    //                             'Debit' => 0,
    //                             'Credit' => $creditAmount,
    //                             'Balance' => $runningBalance -= $creditAmount,
    //                             'IsStandalonePayment' => false,
    //                             'PaymentID' => $payment->PaymentID, // Track payment for potential updates
    //                         ];

    //                         Log::info("Added billing payment to ledger", [
    //                             'PaymentID' => $payment->PaymentID,
    //                             'BillingID' => $billing->BillingID,
    //                             'AmountPaid' => $netAmountPaid,
    //                             'MethodName' => $methodName,
    //                             'IsInsurance' => $isInsurance,
    //                             'ApprovalCode' => $payment->ApprovalCode,
    //                             'CreditApplied' => $creditAmount,
    //                             'TransactionDate' => $paymentTransactionDate,
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }

    //         foreach ($standalonePayments as $payment) {
    //             $paymentDate = $payment->PaymentDate instanceof DateTime
    //                 ? $payment->PaymentDate->toDateTimeString()
    //                 : (new DateTime($payment->PaymentDate ?: now()))->toDateTimeString();
    //             $methodName = $payment->paymentMethod
    //                 ? $payment->paymentMethod->MethodName
    //                 : 'Unknown Method';
    //             $netAmountPaid = floatval($payment->AmountPaid) - floatval($payment->Change);

    //             $ledgerEntries[] = [
    //                 'Service' => 'Standalone Payment',
    //                 'PaymentMethod' => $methodName,
    //                 'TransactionDate' => $paymentDate,
    //                 'Reference' => $payment->ReferenceID ?? 'Payment #' . $payment->PaymentID,
    //                 'Debit' => 0,
    //                 'Credit' => $netAmountPaid,
    //                 'Balance' => $runningBalance -= $netAmountPaid,
    //                 'IsStandalonePayment' => true,
    //             ];
    //         }

    //         foreach ($appointments as $appointment) {
    //             foreach ($appointment->servicesAvailed as $serviceAvailed) {
    //                 if (!$serviceAvailed->service || !$serviceAvailed->treatmentProgress) {
    //                     continue;
    //                 }

    //                 $service = $serviceAvailed->service;
    //                 if (!$service->IsMultiVisit) {
    //                     continue;
    //                 }

    //                 $treatmentProgress = $serviceAvailed->treatmentProgress;
    //                 $treatmentProgressId = $treatmentProgress->TreatmentProgressID;

    //                 if (isset($processedTreatments[$treatmentProgressId])) {
    //                     continue;
    //                 }

    //                 $previousTreatment = null;
    //                 foreach ($treatmentProgresses as $tp) {
    //                     if ($tp->TreatmentName === $service->ServiceName && $tp->PatientID == $patientId && $tp->Status === 'Completed') {
    //                         $previousTreatment = $tp;
    //                         break;
    //                     }
    //                 }

    //                 if ($previousTreatment) {
    //                     $baseTransactionDate = $appointment->AppointmentDate instanceof DateTime
    //                         ? $appointment->AppointmentDate->toDateTimeString()
    //                         : (new DateTime($appointment->AppointmentDate ?: ($appointment->updated_at ?: now())))->toDateTimeString();
    //                     $serviceCost = is_numeric($service->Cost) ? floatval($service->Cost) : 0;

    //                     $ledgerEntries[] = [
    //                         'Service' => $service->ServiceName,
    //                         'PaymentMethod' => null,
    //                         'TransactionDate' => $baseTransactionDate,
    //                         'Reference' => 'Appointment #' . $appointment->AppointmentID,
    //                         'Debit' => $serviceCost,
    //                         'Credit' => 0,
    //                         'Balance' => $runningBalance += $serviceCost,
    //                         'IsStandalonePayment' => false,
    //                     ];

    //                     $processedTreatments[$treatmentProgressId] = [
    //                         'ServiceID' => $service->ServiceID,
    //                         'Status' => $treatmentProgress->Status,
    //                     ];
    //                 }
    //             }
    //         }

    //         // Sort ledger entries by AppointmentID and sequence number
    //         usort($ledgerEntries, function ($a, $b) {
    //             $appointmentA = preg_replace('/[^0-9]/', '', $a['Reference']);
    //             $appointmentB = preg_replace('/[^0-9]/', '', $b['Reference']);
    //             $sequenceA = $this->getSequenceNumber($a['Reference']);
    //             $sequenceB = $this->getSequenceNumber($b['Reference']);
    //             return $appointmentA <=> $appointmentB ?: $sequenceA <=> $sequenceB;
    //         });

    //         $runningBalance = 0;
    //         foreach ($ledgerEntries as &$entry) {
    //             $runningBalance = $runningBalance + $entry['Debit'] - $entry['Credit'];
    //             $entry['Balance'] = $runningBalance;
    //         }

    //         if ($returnBalanceOnly) {
    //             $finalBalance = $ledgerEntries ? end($ledgerEntries)['Balance'] : 0;
    //             Log::info("Returning balance for PatientID: $patientId", ['balance' => $finalBalance]);
    //             return $finalBalance;
    //         }

    //         Log::info("Returning ledger for PatientID: $patientId", ['entries' => $ledgerEntries]);
    //         return response()->json(['ledger' => $ledgerEntries]);
    //     } catch (\Exception $e) {
    //         Log::error("Error fetching ledger for PatientID: $patientId", [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //         return response()->json(['error' => 'Failed to fetch ledger data'], 500);
    //     }
    // }

    // Helper method to determine sequence number based on reference type
    private function getSequenceNumber($reference) {
        if (strpos($reference, 'Appointment #') === 0) return 1; // Appointment first
        if (strpos($reference, 'Adjustment') !== false) return 2; // Adjustment second
        if (strpos($reference, 'Payment #') !== false) return 3; // Payment last
        if (strpos($reference, 'Discount') !== false) return 2; // Discount with adjustment
        return 4; // Default for others (e.g., standalone payments)
    }

    public function getPatientsWithBalances(Request $request)
    {
        Log::info("Fetching patients with balances");

        try {
            // Step 1: Fetch all patients with their full names
            $patients = DB::table('patients')
                ->join('users', 'patients.UserID', '=', 'users.UserID')
                ->select(
                    'patients.PatientID',
                    DB::raw("CONCAT(COALESCE(users.FirstName, ''), ' ', COALESCE(users.LastName, '')) as FullName")
                )
                ->get();

            // Step 2: Calculate the balance for each patient using getPatientLedger
            $patientsWithBalances = [];
            foreach ($patients as $patient) {
                // Call getPatientLedger with $returnBalanceOnly = true to get the balance
                $balance = $this->getPatientLedger($request, $patient->PatientID, true);

                Log::debug("Patient balance from ledger", [
                    'PatientID' => $patient->PatientID,
                    'FullName' => $patient->FullName,
                    'Balance' => $balance,
                ]);

                if ($balance != 0) {
                    $patientsWithBalances[] = [
                        'PatientID' => $patient->PatientID,
                        'FullName' => $patient->FullName,
                        'Balance' => floatval($balance),
                    ];
                }
            }

            Log::info("Returning patients with balances", ['patients' => $patientsWithBalances]);
            return response()->json($patientsWithBalances, 200);
        } catch (\Exception $e) {
            Log::error("Error fetching patients with balances: " . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json(['message' => 'Failed to fetch patients with balances: ' . $e->getMessage()], 500);
        }
    }

    public function addPaymentWithoutAppointment(Request $request)
    {
        Log::info("Adding payment without appointment", ['request' => $request->all()]);

        $referenceIdRules = [
            'Cash' => ['all' => ['nullable']],
            'E-Wallet' => ['all' => ['required', 'string', 'regex:/^[A-Za-z0-9]{12,13}$/']],
            'Bank Payment' => ['all' => ['required', 'string', 'regex:/^[A-Za-z0-9]{12,13}$/']],
            'Insurance' => ['all' => ['nullable']],
        ];

        $rules = [
            'PatientID' => ['required', 'exists:patients,PatientID'],
            'AmountPaid' => ['required', 'numeric', 'min:0'],
            'PaymentMethod' => ['required', 'string'],
            'Change' => ['required', 'numeric', 'min:0'],
        ];

        $paymentMethod = DB::table('payment_methods')
            ->where('MethodName', $request->input('PaymentMethod'))
            ->first();

        if (!$paymentMethod) {
            return response()->json(['message' => 'Invalid payment method selected'], 400);
        }

        $methodType = $paymentMethod->MethodType;
        $methodName = $paymentMethod->MethodName;

        if (isset($referenceIdRules[$methodType])) {
            $specificRules = $referenceIdRules[$methodType]['all'] ?? ['nullable'];
            $rules['ReferenceID'] = array_merge(
                $specificRules,
                [
                    Rule::unique('payments', 'ReferenceID')
                        ->whereNotNull('ReferenceID')
                ]
            );
        } else {
            $rules['ReferenceID'] = ['nullable'];
        }

        try {
            $validated = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            if ($errors->has('ReferenceID')) {
                if ($errors->first('ReferenceID') === 'The Reference ID has already been taken.') {
                    return response()->json(['message' => 'The Reference ID has already been used. Please use a unique Reference ID.'], 422);
                }
                return response()->json(['message' => 'The Reference ID must be 12-13 alphanumeric characters for E-Wallet or Bank Payment methods.'], 422);
            }
            return response()->json(['message' => $errors->first()], 422);
        }

        try {
            DB::beginTransaction();

            $amountPaid = $validated['AmountPaid'];
            $isInsurance = $methodType === 'Insurance' && in_array($methodName, ['Medicard', 'Maxicare']);

            if ($isInsurance) {
                $amountPaid = 0; // Insurance payments start as unpaid
            }

            // Check the current balance to prevent negative balances (unless using Cash)
            $currentBalance = $this->getPatientBalance($validated['PatientID']);
            if ($methodType !== 'Cash' && $amountPaid > $currentBalance) {
                return response()->json(['message' => 'Payment amount cannot exceed the current balance unless using Cash payment.'], 400);
            }

            // Find the most recent unpaid billing for the patient, prioritizing multi-visit services
            $billing = Billing::whereHas('appointment', function ($query) use ($validated) {
                $query->where('PatientID', $validated['PatientID']);
            })
            ->whereHas('appointment.servicesAvailed.service', function ($query) {
                $query->where('IsMultiVisit', true);
            })
            ->where('BillingStatus', '!=', 'Paid')
            ->orderBy('created_at', 'desc')
            ->first();

            if (!$billing) {
                // Fallback to any unpaid billing if no multi-visit billing is found
                $billing = Billing::whereHas('appointment', function ($query) use ($validated) {
                    $query->where('PatientID', $validated['PatientID']);
                })
                ->where('BillingStatus', '!=', 'Paid')
                ->orderBy('created_at', 'desc')
                ->first();
            }

            if (!$billing) {
                return response()->json(['message' => 'No unpaid billing found to apply this payment to.'], 400);
            }

            // Create the payment with NULL BillingID (standalone payment)
            $paymentDate = now()->toDateTimeString();
            $paymentId = DB::table('payments')->insertGetId([
                'PatientID' => $validated['PatientID'],
                'BillingID' => null, // Standalone payment
                'PaymentMethodID' => $paymentMethod->PaymentMethodID,
                'AmountPaid' => $amountPaid,
                'PaymentDate' => $paymentDate,
                'ReferenceID' => $methodType === 'Cash' ? null : ($validated['ReferenceID'] ?? null),
                'Change' => $validated['Change'],
                'ProcessedBy' => Auth::user()->UserID,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update the billing balance and AmountPaid
            $netAmountPaid = $amountPaid - floatval($validated['Change']);
            $newBalance = max(0, $billing->Balance - $netAmountPaid);
            $totalAmountPaid = Payment::where('BillingID', $billing->BillingID)->sum('AmountPaid') + $netAmountPaid;

            $billing->update([
                'Balance' => $newBalance,
                'AmountPaid' => $totalAmountPaid,
                'BillingStatus' => $newBalance == 0 ? 'Paid' : ($totalAmountPaid > 0 ? 'Partially Paid' : 'Unpaid'),
            ]);

            Log::info("Standalone payment recorded and applied to billing", [
                'PaymentID' => $paymentId,
                'BillingID' => $billing->BillingID,
                'PatientID' => $validated['PatientID'],
                'AmountPaid' => $netAmountPaid,
                'NewBalance' => $newBalance,
                'BillingStatus' => $billing->BillingStatus,
            ]);

            DB::commit();

            // Fetch the patient's full name for the response
            $patient = DB::table('patients')
                ->join('users', 'patients.UserID', '=', 'users.UserID')
                ->where('patients.PatientID', $validated['PatientID'])
                ->select(DB::raw("CONCAT(COALESCE(users.FirstName, ''), ' ', COALESCE(users.LastName, '')) as FullName"))
                ->first();

            // Fetch the services associated with the billing for the response
            $appointment = Appointment::with('servicesAvailed.service')->find($billing->AppointmentID);
            $servicesAvailed = $appointment ? $appointment->servicesAvailed : collect();
            $lastService = $servicesAvailed->isNotEmpty() ? $servicesAvailed->first()->service->ServiceName : 'Payment';
            $lastServiceCost = $servicesAvailed->isNotEmpty() ? ($servicesAvailed->first()->UpdatedPrice ?? $servicesAvailed->first()->service->Cost) : $amountPaid;

            // Return a response for a standalone payment, but include the billing it was applied to
            return response()->json([
                'message' => 'Standalone payment recorded and applied successfully',
                'payment' => [
                    'PaymentID' => $paymentId,
                    'PatientID' => $validated['PatientID'],
                    'PatientName' => $patient->FullName,
                    'AppointmentDateTime' => 'Payment without Appointment',
                    'Procedure' => 'Payment without Appointment',
                    'Amount' => floatval($amountPaid),
                    'AmountPaid' => floatval($amountPaid),
                    'TotalAmount' => floatval($amountPaid),
                    'Balance' => 0.00, // Standalone payment has no balance
                    'BillingStatus' => 'Paid', // Standalone payment is considered "Paid"
                    'IsStandalonePayment' => true,
                    'PaymentDate' => $paymentDate,
                    'PaymentMethod' => $methodName,
                    'ReferenceID' => $methodType === 'Cash' ? null : ($validated['ReferenceID'] ?? null),
                    'Change' => floatval($validated['Change']),
                    'AppliedToBillingID' => $billing->BillingID, // Indicate which billing the payment was applied to
                    'services' => [], // No services for standalone payment
                ],
                'billing' => [
                    'BillingID' => $billing->BillingID,
                    'PatientID' => $validated['PatientID'],
                    'PatientName' => $patient->FullName,
                    'AppointmentID' => $billing->AppointmentID,
                    'AppointmentDateTime' => $appointment ? $appointment->AppointmentDate . ' ' . $appointment->AppointmentTime : null,
                    'Procedure' => $lastService,
                    'Amount' => floatval($billing->TotalAmount),
                    'AmountPaid' => floatval($totalAmountPaid),
                    'TotalAmount' => floatval($billing->TotalAmount),
                    'Balance' => floatval($newBalance),
                    'BillingStatus' => $billing->BillingStatus,
                    'IsStandalonePayment' => false,
                    'PaymentDate' => $paymentDate,
                    'services' => $servicesAvailed->map(function ($sa) use ($methodName, $methodType, $validated, $amountPaid, $netAmountPaid) {
                        $serviceCost = $sa->UpdatedPrice ?? $sa->service->Cost;
                        return [
                            'ServiceAvailedID' => $sa->ServiceAvailedID,
                            'ServiceName' => $sa->service->ServiceName,
                            'Cost' => floatval($serviceCost),
                            'AmountPaid' => floatval($amountPaid),
                            'Balance' => floatval($serviceCost - $netAmountPaid),
                            'PaymentStatus' => $netAmountPaid >= $serviceCost ? 'Paid' : ($netAmountPaid > 0 ? 'Partially Paid' : 'Unpaid'),
                            'PaymentMethod' => $methodName,
                            'ReferenceID' => $methodType === 'Cash' ? null : ($validated['ReferenceID'] ?? null),
                            'Change' => floatval($validated['Change']),
                        ];
                    })->all(),
                ],
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error adding payment without appointment: " . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to record payment: ' . $e->getMessage()], 500);
        }
    }

    // Note: getPatientBalance is referenced in addPaymentWithoutAppointment but not defined in the provided code.
    // You may need to implement this method or adjust the logic if it's defined elsewhere.
    private function getPatientBalance($patientId)
    {
        // Placeholder implementation: Fetch the balance using getPatientLedger
        return $this->getPatientLedger(new Request(), $patientId, true);
    }
}
