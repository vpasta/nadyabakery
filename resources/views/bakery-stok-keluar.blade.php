<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok Afkir - Nadya Bakery</title>
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
            </div>

            <nav class="p-4 space-y-2">
                <a href="/kasir" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat Penjualan</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
                <a href="/pengaturan" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-gear text-2xl"></i>
                    <span class="ml-3 font-medium">Pengaturan</span>
                </a>
            </nav>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        <header class="py-4 md:h-20 bg-white border-b border-gray-100 px-4 md:px-8 flex items-center justify-between shadow-sm z-10 shrink-0">
            <div class="flex items-center gap-3">
                <a href="/stok" class="text-gray-400 hover:text-primary transition p-2 bg-gray-50 rounded-lg">
                    <i class="ph ph-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">Riwayat Stok Dibuang (Afkir)</h1>
                    <p class="text-xs text-gray-400">Catatan produk yang tidak layak jual</p>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-primary-soft overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-150">
                        <thead>
                            <tr class="bg-bg text-gray-500 text-sm border-b border-primary-soft">
                                <th class="py-4 px-6 font-semibold">Tanggal</th>
                                <th class="py-4 px-6 font-semibold">Nama Produk</th>
                                <th class="py-4 px-6 font-semibold text-center">Jumlah</th>
                                <th class="py-4 px-6 font-semibold">Alasan</th>
                                <th class="py-4 px-6 font-semibold">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if($stokKeluars->isEmpty())
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Belum ada riwayat pembuangan produk.</td>
                            </tr>
                            @endif

                            @foreach($stokKeluars as $stok)
                            <tr class="hover:bg-red-50/50 transition">
                                <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($stok->created_at)->format('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 font-bold text-dark">{{ $stok->produk->nama_produk ?? 'Produk Telah Dihapus' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-orange-100 text-orange-600 font-bold px-3 py-1 rounded-lg text-sm">
                                        - {{ $stok->jumlah }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded font-medium border border-gray-200">{{ $stok->alasan }}</span>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-500 italic">
                                    {{ $stok->catatan_opsional ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $stokKeluars->links() }}
            </div>
        </div>
    </main>
</body>
</html>