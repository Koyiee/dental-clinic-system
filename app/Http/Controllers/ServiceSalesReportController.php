<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\ServicesAvailed;
use App\Models\Service;
use Carbon\Carbon;

class ServiceSalesReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfWeek());
        $endDate = $request->input('end_date', Carbon::now()->endOfWeek());

        $serviceData = ServicesAvailed::join('appointments', 'services_availed.AppointmentID', '=', 'appointments.AppointmentID')
            ->join('services', 'services_availed.ServiceID', '=', 'services.ServiceID')
            ->where('appointments.AppointmentStatus', 'Completed')
            ->whereBetween('appointments.AppointmentDate', [$startDate, $endDate])
            ->select(
                'services.ServiceID',
                'services.ServiceName',
                'services.Cost',
                \DB::raw('COUNT(*) as BookingCount'),
                'appointments.AppointmentDate as ReportDate'
            )
            ->groupBy('services.ServiceID', 'services.ServiceName', 'services.Cost', 'appointments.AppointmentDate')
            ->orderBy('BookingCount', 'desc')
            ->get();

        $reports = $serviceData->map(function ($item, $index) {
            $item->TotalRevenue = $item->BookingCount * $item->Cost;
            $item->Ranking = $index + 1;
            return $item;
        });

        return response()->json([
            'reports' => $reports,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }
}