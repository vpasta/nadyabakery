<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - Nadya Bakery</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-dark h-screen w-full flex overflow-hidden">
    <aside id="sidebar-menu" class="fixed md:static top-0 left-0 h-full w-64 shrink-0 bg-white border-r border-primary-soft flex flex-col justify-between shadow-2xl md:shadow-none z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div>
            <div class="h-20 flex items-center justify-between px-6 border-b border-pink-50">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-14 h-14 mb-2 block">
                    <span class="ml-1 font-bold text-primary text-xl">Nadya Bakery</span>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500 transition">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>

            <nav class="p-4 space-y-2">
                <a href="/kasir" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg shadow-primary-soft transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
            </nav>
        </div>

        <div class="p-4">
            <a href="/logout" class="flex items-center p-3 text-red-400 hover:bg-red-50 rounded-xl transition">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="ml-3 font-medium">Keluar</span>
            </a>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        <header class="py-4 md:h-20 bg-white border-b border-gray-100 px-4 md:px-8 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div class="flex items-center gap-3 md:gap-0">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 bg-gray-100 hover:bg-pink-100 hover:text-primary p-2 rounded-lg transition">
                    <i class="ph ph-list text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">Riwayat Penjualan</h1>
                    <p class="text-xs text-gray-400 hidden md:block">Daftar semua transaksi Nadya Bakery</p>
                </div>
            </div>
            <div class="bg-pink-50 text-primary px-3 md:px-4 py-2 rounded-xl font-bold text-xs md:text-sm border border-primary-soft">
                <span class="hidden md:inline">Total Transaksi: </span>
                <span class="md:hidden">Total: </span>
                {{ $transaksis->count() }}
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-primary-soft overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-150">
                        <thead>
                            <tr class="bg-bg text-primary border-b border-primary-soft">
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">No. Nota</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Tanggal & Waktu</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Metode</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-right">Total Belanja</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        
                        @if($transaksis->isEmpty())
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Belum ada transaksi saat ini.</td>
                            </tr>
                        @endif

                        @foreach($transaksis as $trx)
                            <tr class="hover:bg-pink-50/50 transition duration-150 group">
                                <td class="py-4 px-4 md:px-6 font-bold text-gray-700">
                                    {{ $trx->nomor_nota }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-4 md:px-6">
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $trx->metode_pembayaran }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 md:px-6 font-bold text-primary text-right">
                                    Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center">
                                    <button onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.remove('hidden')" 
                                            class="text-gray-400 hover:text-secondary transition px-2 py-1 rounded bg-white hover:bg-primary-soft shadow-sm border border-gray-100">
                                        <i class="ph ph-eye text-lg"></i>
                                    </button>
                                </td>
                                
                                <div id="modal-trx-{{ $trx->id }}" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
                                    <div class="fixed inset-0 bg-dark/40 backdrop-blur-sm transition-opacity" 
                                         onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.add('hidden')"></div>
                                
                                    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 z-10 shadow-2xl overflow-hidden flex flex-col max-h-[80vh] border border-primary-soft">
                                        
                                        <div class="p-5 border-b border-primary-soft bg-bg flex justify-between items-center">
                                            <div>
                                                <h3 class="text-lg font-bold text-dark">Detail Transaksi #{{ $trx->id }}</h3>
                                                <p class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                            <button onclick="document.getElementById('modal-trx-{{ $trx->id }}').classList.add('hidden')" 
                                                    class="text-gray-400 hover:text-primary transition p-1">
                                                <i class="ph ph-x text-2xl"></i>
                                            </button>
                                        </div>
                                
                                        <div class="p-6 overflow-y-auto flex-1">
                                            <div class="space-y-4">
                                                {{-- Looping melalui relasi detailTransaksi yang sudah kita buat di Model --}}
                                                @forelse($trx->detailTransaksi as $detail)
                                                <div class="flex justify-between items-center pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                                    <div>
                                                        {{-- Ambil nama_produk dari tabel Produk melalui relasi --}}
                                                        <p class="font-semibold text-dark">{{ $detail->produk->nama_produk ?? 'Produk Terhapus' }}</p>
                                                        <p class="text-sm text-gray-500">
                                                            {{-- Gunakan nama kolom sesuai database: jumlah_beli & harga_satuan --}}
                                                            {{ $detail->jumlah_beli }}x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                    <p class="font-bold text-secondary">
                                                        {{-- Gunakan nama kolom sesuai database: subtotal --}}
                                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                                @empty
                                                <div class="text-center py-4 text-gray-400 italic">
                                                    Belum ada detail produk.
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>
                                
                                        <div class="p-5 border-t border-primary-soft bg-gray-50 flex justify-between items-center">
                                            <span class="font-bold text-gray-600">Total Keseluruhan</span>
                                            <span class="font-bold text-2xl text-primary">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>           
                </div>
            </div>
        </div>

    </main>
    <script>
        // Fungsi untuk membuka dan menutup Sidebar Navigasi di Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                overlay.classList.add('hidden');
            } else {
                overlay.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>