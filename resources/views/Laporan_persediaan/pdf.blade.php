<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Persediaan</title>
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
    <h1>Laporan Persediaan/h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ tanggal_indonesia($item->created_at, false) }}</td>
                        <td>{{ $item->barang->nama }}</td>
                        <td>{{ format_uang($item->total_item) }}</td>
                        <td>Rp.{{ format_uang($item->total_harga) }}</td>
                        <td>Rp.{{ format_uang($item->bayar) }}</td>
                        <td>{{ $item->diskon }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script type="text/javascript">
            window.print();
        </script>
</body>


</html>
