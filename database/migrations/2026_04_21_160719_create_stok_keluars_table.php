<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel stok_keluars.
     */
    public function up(): void
    {
        Schema::create('stok_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade'); 
            $table->integer('jumlah');
            $table->string('alasan'); // Menyimpan alasan: Basi, Rusak, Jatuh, dll.
            $table->text('catatan_opsional')->nullable(); // Catatan tambahan jika diperlukan
            $table->date('tanggal'); // Tanggal produk dibuang
            $table->timestamps();
        });
    }

    /**
     * Balikkan (hapus) tabel jika di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_keluars');
    }
};