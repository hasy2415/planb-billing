<!DOCTYPE html>
<html>
<head>
    <title>Plan B Auto Detailing Expert - Billing</title>
</head>
<body>

    <h1>Plan B Auto Detailing Expert</h1>
    <h2>Create Bill</h2>

    <form action="/invoice" method="POST">
        @csrf

        <p>
            <label>Customer Name</label><br>
            <input type="text" name="customer_name" required>
        </p>

        <p>
            <label>Phone Number</label><br>
            <input type="text" name="phone">
        </p>

        <p>
            <label>Vehicle Number</label><br>
            <input type="text" name="vehicle_number">
        </p>

        <p>
            <label>Vehicle Model</label><br>
            <input type="text" name="vehicle_model">
        </p>

        <div id="services">
    <div class="service-row">
        <input
            type="text"
            name="services[]"
            placeholder="Service Name"
            required
        >

        <input
            type="number"
            name="amounts[]"
            placeholder="Amount"
            min="0"
            step="0.01"
            required
        >
    </div>
</div>

<br>

<button type="button" onclick="addService()">
    + Add Another Service
</button>

        <button type="submit">Generate Bill</button>
    </form>
    <script>
function addService() {
    const container = document.getElementById('services');

    const row = document.createElement('div');
    row.className = 'service-row';
    row.style.marginTop = '10px';

    row.innerHTML = `
        <input
            type="text"
            name="services[]"
            placeholder="Service Name"
            required
        >

        <input
            type="number"
            name="amounts[]"
            placeholder="Amount"
            min="0"
            step="0.01"
            required
        >
    `;

    container.appendChild(row);
}
</script>

</body>
</html>