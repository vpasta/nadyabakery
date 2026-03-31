<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $guarded = ['id'];

    // Relasi: 1 Transaksi memiliki Banyak (hasMany) Detail Transaksi
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}