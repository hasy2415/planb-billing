<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('billing');
});

Route::post('/invoice', function (Request $request) {
    $data = $request->validate([
        'customer_name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'vehicle_number' => 'nullable|string|max:100',
        'vehicle_model' => 'nullable|string|max:255',
        'services' => 'required|array|min:1',
        'services.*' => 'required|string|max:255',
        'amounts' => 'required|array|min:1',
        'amounts.*' => 'required|numeric|min:0',
    ]);

    $invoice = Invoice::create([
        'customer_name' => $data['customer_name'],
        'phone' => $data['phone'] ?? null,
        'vehicle_number' => $data['vehicle_number'] ?? null,
        'vehicle_model' => $data['vehicle_model'] ?? null,
        'services' => $data['services'],
        'amounts' => $data['amounts'],
    ]);

    return view('invoice', [
        'data' => $data,
        'invoice' => $invoice,
    ]);
});

// Dashboard for billing data and revenue
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/export', [DashboardController::class, 'export']);

// View a saved invoice (GET)
Route::get('/invoice/{invoice}', function (Invoice $invoice) {
    return view('invoice', [
        'data' => [
            'customer_name' => $invoice->customer_name,
            'phone' => $invoice->phone,
            'vehicle_number' => $invoice->vehicle_number,
            'vehicle_model' => $invoice->vehicle_model,
            'services' => $invoice->services ?? [],
            'amounts' => $invoice->amounts ?? [],
        ],
        'invoice' => $invoice,
    ]);
})->name('invoice.show');
