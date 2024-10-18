<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'penjualan_piutang',
            function (Blueprint $table) {
                $table->increments('id_penjualan_piutang');
                $table->integer('id_penjualan');
                $table->integer('id_barang');
                $table->integer('harga_jual');
                $table->integer('jumlah');
                $table->integer('subtotal');
                $table->integer('bayar')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_piutang');
    }
};
