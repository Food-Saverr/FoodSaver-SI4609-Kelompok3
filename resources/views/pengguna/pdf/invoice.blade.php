<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Invoice</h1>
        <p>FoodSaver Donasi</p>
    </div>

    <table class="table">
        <tr>
            <th>Full Name</th>
            <td>{{ $full_name }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $phone }}</td>
        </tr>
        {{-- <tr>
            <th>Status</th>
            <td>{{ $status }}</td>
        </tr> --}}
        <tr>
            <th>Payment Method</th>
            <td>{{ $payment_method }}</td>
        </tr>
        <tr>
            <th>Nominal Donasi</th>
            <td>Rp {{ number_format($nominal, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Thank you for using Donating on FoodSaver!</p>
    </div>
</body>

</html>
