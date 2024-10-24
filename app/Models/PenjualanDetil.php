<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetil extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detil';
    protected $primaryKey = 'id_penjualan_detil';
    protected $guarded = [];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id_barang', 'id_barang');
    }
}
