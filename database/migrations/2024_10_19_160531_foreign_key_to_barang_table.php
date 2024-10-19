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
        Schema::table('barang', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('barang', 'id_kategori')) {
                $table->unsignedInteger('id_kategori');
            }

            // Definisikan foreign key
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->onUpdate('restrict')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('id_kategori')->change();
            $table->dropForeign('barang_id_kategori_foreign');
        });
    }
};
