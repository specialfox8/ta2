<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetilController;
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
});
