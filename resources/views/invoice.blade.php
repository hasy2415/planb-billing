<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
   <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #f4f4f4;
        padding: 30px;
    }

    .invoice {
        max-width: 850px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    h1, h2, h3 {
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 10px;
    }

    th {
        background: #f2f2f2;
    }

    .text-right {
        text-align: right;
    }

    .total-row td {
        font-weight: bold;
        font-size: 18px;
    }

    .footer {
        margin-top: 40px;
        text-align: center;
        font-size: 14px;
        color: #555;
    }

    @media print {
        .no-print {
            display: none;
        }

        body {
            background: white;
            padding: 0;
        }

        .invoice {
            border: none;
            box-shadow: none;
        }
    }
</style>
</head>
<div class="invoice">

    <div class="header">
        <div>
            <h1>PLAN B AUTO DETAILING EXPERT</h1>
            <p>
                No.20 c Natarajan Street,<br>  Chennai 600078
                Periyar Nagar Nesapakkam<br>
                Chennai, Tamil Nadu<br>
                📞 +91 9551122330<br>
                ✉️ planbautodetailing
            </p>
        </div>

        <div class="text-right">
            <h2>INVOICE</h2>
            <p>Date: {{ date('d-m-Y') }}</p>
            <p>Invoice #: {{ 'INV-' . time() }}</p>
        </div>
    </div>

    <h3>Customer Details</h3>

    <p><strong>Name:</strong> {{ $data['customer_name'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>

    <h3>Vehicle Details</h3>

    <p><strong>Vehicle No:</strong> {{ $data['vehicle_number'] }}</p>
    <p><strong>Vehicle Model:</strong> {{ $data['vehicle_model'] }}</p>

    @php
        $total = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th class="text-right">Amount (₹)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data['services'] as $index => $service)
                @php
                    $amount = (float) ($data['amounts'][$index] ?? 0);
                    $total += $amount;
                @endphp

                <tr>
                    <td>{{ $service }}</td>
                    <td class="text-right">
                        {{ number_format($amount, 2) }}
                    </td>
                </tr>
            @endforeach

            <tr class="total-row">
                <td>Total</td>
                <td class="text-right">
                    ₹{{ number_format($total, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Thank you for choosing Plan B Auto Detailing Expert.</p>
        <p>We appreciate your business and look forward to serving you again.</p>
    </div>

    <button class="no-print" onclick="window.print()">
        Print Invoice
    </button>

</div></body>
</html>