<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetil extends Model
{
    use HasFactory;
    protected $table = 'pembelian_detil';
    protected $primaryKey = 'id_pembelian_detil';
    protected $guarded = [];

    public function barang()
    {
        return $this->hasOne(Barang::class, 'id_barang', 'id_barang');
    }
}
