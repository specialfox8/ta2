<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan Penghasilan Seluruh Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h1>Laporan Pendapatan Penghasilan Seluruh Transaksi</h1>
    <p><strong>Periode: </strong>{{ tanggal_indonesia($tanggalawal) }} - {{ tanggal_indonesia($tanggalakhir) }}</p>

    <table>
        <thead>
            <tr>
                <th>Pembelian</th>
                <th>Penjualan</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>

                    <td>{{ $item['pembelian'] }}</td>
                    <td>{{ $item['penjualan'] }}</td>
                    <td>{{ $item['pendapatan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
