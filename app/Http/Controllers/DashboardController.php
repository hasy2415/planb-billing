<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $invoices = (clone $query)->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $totalRevenue = (clone $query)->get()->reduce(function ($carry, $inv) {
            return $carry + (float) $inv->total;
        }, 0);

        return view('dashboard', [
            'invoices' => $invoices,
            'totalRevenue' => $totalRevenue,
        ]);
    }

    public function export(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $invoices = $query->orderBy('created_at', 'desc')->get();

        $response = new StreamedResponse(function () use ($invoices) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Invoice ID', 'Date', 'Customer', 'Phone', 'Vehicle No', 'Vehicle Model', 'Services', 'Amounts', 'Total']);

            foreach ($invoices as $inv) {
                fputcsv($handle, [
                    $inv->id,
                    $inv->created_at->toDateTimeString(),
                    $inv->customer_name,
                    $inv->phone,
                    $inv->vehicle_number,
                    $inv->vehicle_model,
                    implode(' | ', $inv->services ?? []),
                    implode(' | ', $inv->amounts ?? []),
                    number_format($inv->total, 2, '.', ''),
                ]);
            }

            fclose($handle);
        });

        $filename = 'invoices_export_'.date('Ymd_His').'.csv';
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}
