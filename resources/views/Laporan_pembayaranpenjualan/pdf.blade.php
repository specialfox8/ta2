<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran Piutang</title>
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
    <h1>Laporan Pembayaran Piutang </h1>
    <p>Periode: {{ tanggal_indonesia($tanggalawal, false) }} - {{ tanggal_indonesia($tanggalakhir, false) }}</p>
    <p>Status Pembayaran: {{ $status ?: 'Semua' }}</p>


    <h3>Total Harga Pendapatan Pembelian: Rp.{{ format_uang($totalPendapatan) }}</h3>

    @foreach ($penjualan as $key => $item)
        <h3>Penjualan {{ $key + 1 }}</h3>
        <table>
            <tr>
                <th>Kode Penjualan</th>
                <td>{{ $item->kode_penjualan }}</td>
            </tr>
            {{-- <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ tanggal_indonesia($item->updated_at, false) }}</td>
            </tr> --}}

            <tr>
                <th>Tanggal Pembayaran</th>
                <td>{{ $item->status === 'belum lunas' ? '-' : tanggal_indonesia($item->updated_at, false) }}</td>
            </tr>

            <tr>
                <th>konsumen</th>
                <td>{{ $item->konsumen->nama }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp.{{ format_uang($item->total_harga) }}</td>
            </tr>
            <tr>
                <th>Bayar</th>
                <td>Rp.{{ format_uang($item->bayar) }}</td>
            </tr>
            <tr>
                <th>Diskon</th>
                <td>{{ $item->diskon }}%</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $item->status }}</td>
            </tr>
        </table>

        <h4>Detail Pembelian</h4>
        <table class="detail-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->detil as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->kode_barang }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>Rp.{{ format_uang($detail->harga_jual) }}</td>
                        <td>{{ format_uang($detail->jumlah) }}</td>
                        <td>Rp.{{ format_uang($detail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <script type="text/javascript">
        window.print();
    </script>
</body>


</html>
