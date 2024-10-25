<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Laporan Penjualan</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Konsumen</th>
                <th>Total Item</th>
                <th>Total Harga</th>
                <th>Bayar</th>
                <th>Diskon</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ tanggal_indonesia($item->created_at, false) }}</td>
                    <td>{{ $item->konsumen->nama }}</td>
                    <td>{{ format_uang($item->total_item) }}</td>
                    <td>Rp.{{ format_uang($item->total_harga) }}</td>
                    <td>Rp.{{ format_uang($item->bayar) }}</td>
                    <td>{{ $item->diskon }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
