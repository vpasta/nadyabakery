<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Beri tahu Laravel nama tabel aslinya
    protected $table = 'kategori';
    
    // (Opsional) agar kita bisa input data dengan mudah nanti
    protected $guarded = ['id'];
}
