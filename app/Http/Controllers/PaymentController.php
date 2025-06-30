<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function recordPayment(Request $request, $billingId)
    {
        $validPaymentMethods = DB::table('payment_methods')->pluck('MethodName')->toArray();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in($validPaymentMethods)],
            'reference_id' => 'nullable|string|max:13',
        ]);

        $billing = Billing::findOrFail($billingId);
        $paymentAmount = $validated['amount'];

        if ($paymentAmount > $billing->Balance) {
            return response()->json(['error' => 'Payment exceeds balance'], 400);
        }

        if ($validated['payment_method'] === 'Gcash') {
            if (!isset($validated['reference_id']) || !preg_match('/^\d{13}$/', $validated['reference_id'])) {
                return response()->json(['error' => 'Gcash payments require a valid 13-digit Reference ID'], 400);
            }
        }

        $paymentMethod = DB::table('payment_methods')
            ->where('MethodName', $validated['payment_method'])
            ->first();

        if (!$paymentMethod) {
            return response()->json(['error' => 'Invalid payment method'], 400);
        }

        $payment = Payment::create([
            'BillingID' => $billingId,
            'PaymentMethodID' => $paymentMethod->PaymentMethodID,
            'PaymentMethod' => $paymentMethod->MethodName,
            'AmountPaid' => $paymentAmount,
            'ReferenceID' => $validated['reference_id'] ?? null,
            'PaymentDate' => now(),
        ]);

        $totalPayments = $billing->payments->sum('AmountPaid');
        $billing->Balance = max(0, $billing->TotalAmount - $billing->Discount - $totalPayments);
        $billing->BillingStatus = $billing->Balance <= 0 ? 'Paid' : ($totalPayments > 0 ? 'Partially Paid' : 'Unpaid');
        $billing->save();

        Log::info("Payment recorded for BillingID: $billingId", [
            'PaymentID' => $payment->PaymentID,
            'AmountPaid' => $paymentAmount,
            'PaymentMethodID' => $payment->PaymentMethodID,
            'ReferenceID' => $payment->ReferenceID,
            'NewBalance' => $billing->Balance,
            'BillingStatus' => $billing->BillingStatus,
        ]);

        return response()->json(['message' => 'Payment recorded', 'billing' => $billing], 200);
    }
}