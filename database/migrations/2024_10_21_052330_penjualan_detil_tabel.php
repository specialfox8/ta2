<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_detil', function (Blueprint $table) {
            $table->increments('id_penjualan_detil');
            $table->integer('id_penjualan');
            $table->integer('id_produk');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->tinyInteger('diskon')->default(0);
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detil');
    }
};
