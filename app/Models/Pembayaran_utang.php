<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran_utang extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_utang';
    protected $primaryKey = 'id_pembayaran_utang';
    protected $fillable = ['status'];
    protected $guarded = [];
}
