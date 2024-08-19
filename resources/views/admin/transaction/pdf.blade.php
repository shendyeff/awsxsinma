<!DOCTYPE html>
<html>

<head>
    <title>Transactions Report</title>
    <style>
    /* Add some basic styling to the PDF */
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h2>Transactions Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Customer</th>
                <th>Nama Produk</th>
                <th>Kategori Produk</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $i => $transaction)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>
                    @foreach ($transaction->details as $details)
                    <li>{{ $details->product->name }}</li>
                    @endforeach
                </td>
                <td>
                    @foreach ($transaction->details as $details)
                    <li>{{ $details->product->category->name }}</li>
                    @endforeach
                </td>
                <td>
                    @foreach ($transaction->details as $details)
                    <li>{{ $details->quantity }} - {{ $details->product->unit }}</li>
                    @endforeach
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4"><strong>Total Barang Keluar</strong></td>
                <td><strong>{{ $grandQuantity }} Barang</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>