<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\LaporanPembayaranPembelianController;
use App\Http\Controllers\LaporanPembayaranPenjualanController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\LaporanPersediaanController;
use App\Http\Controllers\PembayaranPiutangController;
use App\Http\Controllers\PembayranUtangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetilController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetilController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => redirect()->route('login'));

Route::middleware([
    'auth:sanctum',
    'verified'
])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/barang/data', [BarangController::class, 'data'])->name('barang.data');
    Route::post('/barang/delete-selected', [BarangController::class, 'deleteSelected'])->name('produk.delete_selected');
    Route::resource('/barang', BarangController::class);

    Route::get('/konsumen/data', [KonsumenController::class, 'data'])->name('konsumen.data');
    Route::resource('/konsumen', KonsumenController::class);

    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);

    Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
    Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::resource('/pembelian', PembelianController::class)
        ->except('create');

    Route::get('/pembelian_detail/{id}/data', [PembelianDetilController::class, 'data'])->name('pembelian_detail.data');
    Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetilController::class, 'loadForm'])->name('pembelian_detail.load.form');
    Route::resource('/pembelian_detail', PembelianDetilController::class)
        ->except('create', 'show', 'edit');

    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan/{id}/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::resource('/penjualan', PenjualanController::class)
        ->except('create');

    Route::get('/penjualan_detail/{Sid}/data', [PenjualanDetilController::class, 'data'])->name('penjualan_detail.data');
    Route::get('/penjualan_detail/loadform/{diskon}/{total}', [PenjualanDetilController::class, 'loadForm'])->name('penjualan_detail.load.form');

    Route::resource('/penjualan_detail', PenjualanDetilController::class)
        ->except('create', 'show', 'edit');

    Route::get('/laporan_penjualan', [LaporanPenjualanController::class, 'index'])->name('laporan_penjualan.index');
    Route::post('/laporan_penjualan/refresh', [LaporanPenjualanController::class, 'refresh'])->name('laporan_penjualan.refresh');
    Route::get('/laporan_penjualan/data', [LaporanPenjualanController::class, 'data'])->name('laporan_penjualan.data');
    Route::get('/laporan_penjualan/exportpdf', [LaporanPenjualanController::class, 'exportpdf'])->name('laporan_penjualan.exportpdf');



    Route::get('/laporan_pembelian', [LaporanPembelianController::class, 'index'])->name('laporan_pembelian.index');
    Route::post('/laporan_pembelian/refresh', [LaporanPembelianController::class, 'refresh'])->name('laporan_pembelian.refresh');
    Route::get('/laporan_pembelian/data', [LaporanPembelianController::class, 'data'])->name('laporan_pembelian.data');
    Route::get('/laporan_pembelian/exportpdf', [LaporanPembelianController::class, 'exportpdf'])->name('laporan_pembelian.exportpdf');


    // Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    // Route::get('/penjualan/{id}/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::get('pembayaran_penjualan/data', [PembayaranPiutangController::class, 'data'])->name('pembayaran_penjualan.data');
    Route::put('pembayaran_penjualan/{id}/status', [PembayaranPiutangController::class, 'updateStatus'])->name('pembayaran_penjualan.updateStatus');
    Route::resource('/pembayaran_penjualan', PembayaranPiutangController::class)
        ->except('create');

    Route::get('pembayaran_pembelian/data', [PembayranUtangController::class, 'data'])->name('pembayaran_pembelian.data');
    Route::put('pembayaran_pembelian//{id}/status', [PembayranUtangController::class, 'updateStatus'])->name('pembayaran_pembelian.updateStatus');
    Route::resource('/pembayaran_pembelian', PembayranUtangController::class)
        ->except('create');

    Route::get('/laporan_pembayaranpembelian', [LaporanPembayaranPembelianController::class, 'index'])->name('laporan_pembayaranpembelian.index');
    Route::post('/laporan_pembayaranpembelian/refresh', [LaporanPembayaranPembelianController::class, 'refresh'])->name('laporan_pembayaranpembelian.refresh');
    Route::get('/laporan_pembayaranpembelian/data', [LaporanPembayaranPembelianController::class, 'data'])->name('laporan_pembayaranpembelian.data');
    Route::get('/laporan_pembayaranpembelian/exportpdf', [LaporanPembayaranPembelianController::class, 'exportpdf'])->name('laporan_pembayaranpembelian.exportpdf');
    Route::get('laporan-pembayaran-pembelian/total-pendapatan', [LaporanPembayaranPembelianController::class, 'getTotalPendapatan'])->name('laporan_pembayaranpembelian.getTotalPendapatan');

    Route::get('/laporan_pembayaranpenjualan', [LaporanPembayaranPenjualanController::class, 'index'])->name('laporan_pembayaranpenjualan.index');
    Route::post('/laporan_pembayaranpenjualan/refresh', [LaporanPembayaranPenjualanController::class, 'refresh'])->name('laporan_pembayaranpenjualan.refresh');
    Route::get('/laporan_pembayaranpenjualan/data', [LaporanPembayaranPenjualanController::class, 'data'])->name('laporan_pembayaranpenjualan.data');
    Route::get('/laporan_pembayaranpenjualan/exportpdf', [LaporanPembayaranPenjualanController::class, 'exportpdf'])->name('laporan_pembayaranpenjualan.exportpdf');
    Route::get('laporan-pembayaran-penjualan/total-pendapatan', [LaporanPembayaranPenjualanController::class, 'getTotalPendapatan'])->name('laporan_pembayaranpenjualan.getTotalPendapatan');

    Route::get('/laporan_persediaan', [LaporanPersediaanController::class, 'index'])->name('laporan_persediaan.index');
    Route::get('/laporan_persediaan/data', [LaporanPersediaanController::class, 'data'])->name('laporan_persediaan.data');
    Route::get('/laporan_persediaan/exportpdf', [LaporanPersediaanController::class, 'exportpdf'])->name('laporan_persediaan.exportpdf');
});
