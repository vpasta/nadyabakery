<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $guarded = ['id'];

    // Relasi: 1 Detail Transaksi ini milik (belongsTo) 1 Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}