<!DOCTYPE html>
<html>

<head>
    <title>Daftar Barang Keluar</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            /* Smaller font size for the entire document */
        }

        /* Container for content */
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }

        /* Header styling */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            /* Smaller font size for header */
            color: #333;
        }

        .header p {
            font-size: 12px;
            /* Smaller font size for subheader */
            color: #777;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Footer styling */
        .footer {
            margin-top: 20px;
            text-align: right;
        }

        .footer p {
            font-size: 12px;
            /* Smaller font size for footer */
            font-weight: bold;
            color: #333;
        }

        /* List styling */
        .product-list,
        .category-list,
        .quantity-list {
            margin: 0;
            padding: 0;
            list-style: none;
            /* Remove bullets from list */
        }

        .product-list li,
        .category-list li,
        .quantity-list li {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Daftar Barang Keluar</h2>
            <p>Report generated on {{ date('d-m-Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
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
                        <ul class="product-list">
                            @foreach ($transaction->details as $details)
                            <li>{{ $details->product->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="category-list">
                            @foreach ($transaction->details as $details)
                            <li>{{ $details->product->category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="quantity-list">
                            @foreach ($transaction->details as $details)
                            <li>{{ $details->quantity }} {{ $details->product->unit }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total Barang Keluar</td>
                    <td style="font-weight: bold;">{{ $grandQuantity }} Barang</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Sinma Official!</p>
        </div>
    </div>
</body>

</html>