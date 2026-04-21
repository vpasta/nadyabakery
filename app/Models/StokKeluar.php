<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara spesifik
    protected $table = 'stok_keluars'; 

    // Mengizinkan semua kolom diisi secara massal kecuali ID
    protected $guarded = ['id']; 

    /**
     * Relasi: Setiap 1 data stok keluar adalah milik 1 Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}