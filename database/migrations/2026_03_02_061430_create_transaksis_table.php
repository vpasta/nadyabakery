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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_nota')->unique(); 
        $table->string('nama_kasir'); 
        $table->integer('total_harga');
        $table->integer('pajak')->default(0);
        $table->integer('total_bayar');
        $table->string('metode_pembayaran'); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
