<!DOCTYPE html>
<html>
<head>
    <title>Billing Dashboard</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
        .filters { margin-bottom: 12px; }
        .text-right { text-align: right; }
    </style>
    </head>
<body>

    <h1>Billing Dashboard</h1>

    <div class="filters">
        <form method="GET" action="/dashboard">
            <label>From: <input type="date" name="from" value="{{ request('from') }}"></label>
            <label>To: <input type="date" name="to" value="{{ request('to') }}"></label>
            <button type="submit">Filter</button>
            <a href="/dashboard">Clear</a>
            <a style="margin-left:20px;" href="/dashboard/export?from={{ request('from') }}&to={{ request('to') }}">Export CSV</a>
        </form>
    </div>

    <h3>Total Revenue: ₹{{ number_format($totalRevenue, 2) }}</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th class="text-right">Total (₹)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $inv)
                <tr>
                    <td>{{ $inv->id }}</td>
                    <td>{{ $inv->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $inv->customer_name }}</td>
                    <td>{{ $inv->vehicle_number }}<br>{{ $inv->vehicle_model }}</td>
                    <td class="text-right">₹{{ number_format($inv->total, 2) }}</td>
                    <td><a href="/invoice/{{ $inv->id }}">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px;">
        {{ $invoices->links() }}
    </div>

</body>
</html>
