<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk; // Tambahkan ini
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function prosesCheckout(Request $request)
    {
        $keranjang = $request->keranjang;
        $metode = $request->metode_pembayaran ?? 'Tunai'; // Ambil metode dari JS

        if (empty($keranjang)) {
            return response()->json(['success' => false, 'message' => 'Keranjang masih kosong.']);
        }

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($keranjang as $item) {
                $subtotal += $item['harga'] * $item['qty'];
            }
            $pajak = $subtotal * 0.10; 
            $total_bayar = $subtotal + $pajak;

            // 1. Simpan Transaksi Utama
            $transaksiBaru = Transaksi::create([
                'nomor_nota' => 'NDY-' . time(), 
                'nama_kasir' => 'Kasir Nadya', 
                'total_harga' => $subtotal,
                'pajak' => $pajak,
                'total_bayar' => $total_bayar,
                'metode_pembayaran' => ucfirst($metode) 
            ]);

            // 2. Simpan Detail & Kurangi Stok
            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksiBaru->id,
                    'produk_id' => $item['id'],
                    'jumlah_beli' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty']
                ]);

                // Logika Pengurangan Stok
                $produk = Produk::find($item['id']);
                if ($produk) {
                    $produk->stok -= $item['qty'];
                    $produk->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true, 
                'pesan' => 'Pembayaran berhasil!',
                'nota' => $transaksiBaru->nomor_nota
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Fungsi baru untuk Hapus Riwayat
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);

            // Jika user memilih kembalikan stok
            if ($request->restore_stock == 'true') {
                foreach ($transaksi->detailTransaksi as $detail) {
                    $produk = Produk::find($detail->produk_id);
                    if ($produk) {
                        $produk->stok += $detail->jumlah_beli;
                        $produk->save();
                    }
                }
            }

            $transaksi->detailTransaksi()->delete();
            $transaksi->delete();

            DB::commit();
            return back()->with('success', 'Riwayat transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function riwayat()
    {
        $transaksis = Transaksi::with(['detailTransaksi.produk'])
                               ->orderBy('created_at', 'desc')
                               ->get();
        return view('bakery-history', compact('transaksis'));
    }
}