<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Barang Keluar</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.6;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h2 {
        margin: 0;
        font-size: 18px;
    }

    .header p {
        margin: 5px 0;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        font-size: 14px;
    }

    td {
        font-size: 12px;
    }

    .footer {
        margin-top: 30px;
        text-align: right;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Data Barang Keluar</h2>
        <p>Periode: {{ $fromDate }} - {{ $toDate }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Kuantitas Barang Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            @foreach ($transaction->details as $details)
            <tr>
                <td>{{ $details->product->name }}</td>
                <td>{{ $details->product->category->name }}</td>
                <td>{{ $details->product->quantity }} {{ $details->product->unit }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Sinma Official!</strong></p>
    </div>

</body>

</html>