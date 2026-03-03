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

    <aside class="w-20 md:w-64 bg-white border-r border-pink-100 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="h-20 flex items-center justify-center border-b border-pink-50">
                <span class="text-3xl">🧁</span>
                <span class="ml-2 font-bold text-pastel-dark text-xl hidden md:block">POS System</span>
            </div>

            <nav class="p-4 space-y-2">
                <a href="/kasir" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-cash-register text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Kasir</span>
                </a>
                <a href="/riwayat" class="flex items-center p-3 text-white bg-pastel-dark rounded-xl shadow-lg shadow-pink-200 transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium hidden md:block">Riwayat</span>
                </a>
            </nav>
        </div>

        <div class="p-4">
            <a href="/logout" class="flex items-center p-3 text-red-400 hover:bg-red-50 rounded-xl transition">
                <i class="ph ph-sign-out text-2xl"></i>
                <span class="ml-3 font-medium hidden md:block">Keluar</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full bg-gray-50">
        
        <header class="h-20 bg-white border-b border-gray-100 px-8 flex items-center justify-between shadow-sm z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Riwayat Penjualan</h1>
                <p class="text-xs text-gray-400">Daftar semua transaksi Nadya Bakery</p>
            </div>
            <div class="bg-pink-50 text-pastel-dark px-4 py-2 rounded-xl font-bold text-sm border border-pink-100">
                Total Transaksi: {{ $transaksis->count() }}
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pastel-bg text-pastel-dark border-b border-pink-100">
                            <th class="py-4 px-6 font-semibold text-sm">No. Nota</th>
                            <th class="py-4 px-6 font-semibold text-sm">Tanggal & Waktu</th>
                            <th class="py-4 px-6 font-semibold text-sm">Metode</th>
                            <th class="py-4 px-6 font-semibold text-sm text-right">Total Belanja</th>
                            <th class="py-4 px-6 font-semibold text-sm text-center">Aksi</th>
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
                            <td class="py-4 px-6 font-bold text-gray-700">
                                {{ $trx->nomor_nota }}
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ $trx->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-bold text-pastel-dark text-right">
                                Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-center">
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

    </main>

</body>
</html>