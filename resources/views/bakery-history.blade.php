<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style> body { font-family: 'Poppins', sans-serif; } </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#ffe4e6',
                        'pastel-dark': '#be185d',
                        'pastel-bg': '#fff1f2',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-700 h-screen overflow-hidden flex">

    <aside id="sidebar-menu" class="fixed md:static top-0 left-0 h-full w-64 bg-white border-r border-pink-100 flex flex-col justify-between shadow-2xl md:shadow-none z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div>
            <div class="h-20 flex items-center justify-between px-6 border-b border-pink-50">
                <div class="flex items-center">
                    <span class="text-3xl">🧁</span>
                    <span class="ml-2 font-bold text-pastel-dark text-xl">Nadya Bakery</span>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500 transition">
                    <i class="ph ph-x text-2xl"></i>
                </button>
            </div>

            <nav class="p-4 space-y-2">
                <a href="/kasir" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-white bg-pastel-dark rounded-xl shadow-lg shadow-pink-200 transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
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

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity"></div>

    <main class="flex-1 flex flex-col h-full bg-gray-50">
        
        <header class="py-4 md:h-20 bg-white border-b border-gray-100 px-4 md:px-8 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div class="flex items-center gap-3 md:gap-0">
                <button onclick="toggleSidebar()" class="md:hidden text-gray-500 bg-gray-100 hover:bg-pink-100 hover:text-pastel-dark p-2 rounded-lg transition">
                    <i class="ph ph-list text-xl"></i>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">Riwayat Penjualan</h1>
                    <p class="text-xs text-gray-400 hidden md:block">Daftar semua transaksi Nadya Bakery</p>
                </div>
            </div>
            <div class="bg-pink-50 text-pastel-dark px-3 md:px-4 py-2 rounded-xl font-bold text-xs md:text-sm border border-pink-100">
                <span class="hidden md:inline">Total Transaksi: </span>
                <span class="md:hidden">Total: </span>
                {{ $transaksis->count() }}
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-pastel-bg text-pastel-dark border-b border-pink-100">
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
                                <td class="py-4 px-4 md:px-6 font-bold text-pastel-dark text-right">
                                    Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center">
                                    <button class="text-gray-400 hover:text-pastel-dark transition px-2 py-1 rounded bg-gray-50 hover:bg-pink-100">
                                        <i class="ph ph-eye text-lg"></i>
                                    </button>
                                </td>
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