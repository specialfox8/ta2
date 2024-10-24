<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Penjualan;
use App\Models\PenjualanDetil;
use Illuminate\Http\Request;

class PenjualanDetilController extends Controller
{
    public function index()
    {
        $id_penjualan = session('id_penjualan');
        $barang = Barang::orderBy('nama_barang')->get();
        $konsumen = Konsumen::find(session('id_konsumen'));
        $diskon = Penjualan::find($id_penjualan)->diskon ?? 0;


        if (! $konsumen) {
            abort(404);
        }

        return view('penjualan_detail.index', compact('id_penjualan', 'barang', 'konsumen', 'diskon'));
    }

    public function data($id)
    {
        $detil = PenjualanDetil::with('barang')
            ->where('id_penjualan', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detil as  $item) {
            $row = array();
            $row['kode_barang'] = '<span class="label label-success">' . $item->barang['kode_barang'] . '</span>';
            $row['nama_barang'] = $item->barang['nama_barang'];
            $row['harga'] = 'Rp. ' . format_uang($item->harga);
            $row['jumlah'] =
                '<input type="number" class="form-control input-sm editjumlah" data-id="' . $item->id_penjualan_detil . '" value="' . $item->jumlah . '">';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['aksi'] =
                '<div class="btn-group">
                <button onclick="deleteData(`' . route('penjualan_detail.destroy', $item->id_penjualan_detil) . '`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>';

            // $row['aksi'] = '<div class="btn-group">
            //     <button onclick="deleteData()" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
            //     </div>';
            $data[] = $row;

            $total += $item->harga * $item->jumlah;
            $total_item += $item->jumlah;
        }

        $data[] = [
            'kode_barang' => '<div class="total hide">' . $total . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'nama_barang' => '',
            'harga' => '',
            'jumlah' => '',
            'subtotal' => '',
            'aksi' => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_barang', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $barang = Barang::where('id_barang', $request->id_barang)->first();
        if (! $barang) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detil = new PenjualanDetil();
        $detil->id_penjualan = $request->id_penjualan;
        $detil->id_barang = $barang->id_barang;
        $detil->harga = $barang->harga;
        $detil->jumlah = 1;
        $detil->subtotal = $barang->harga;
        $detil->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detil = PenjualanDetil::find($id);
        $detil->jumlah = $request->jumlah;
        $detil->subtotal = $detil->harga * $request->jumlah;
        $detil->update();
    }

    public function destroy($id)
    {
        $detail = PenjualanDetil::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        // dd($diskon, $total);
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            // 'tampil-terbilang' => ucwords(terbilang($bayar) . ' Rupiah')
        ];

        return response()->json($data);
    }
}
