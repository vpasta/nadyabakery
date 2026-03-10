<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Produk - Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style> 
        body { font-family: 'Poppins', sans-serif; } 
        /* Scrollbar cantik agar sesuai tema */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #fbcfe8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #be185d; }
    </style>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-pastel-dark rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-white bg-pastel-dark rounded-xl shadow-lg shadow-pink-200 transition">
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
                    <h1 class="text-lg md:text-xl font-bold text-gray-800">Stok Produk</h1>
                    <p class="text-xs text-gray-400 hidden md:block">Pantau ketersediaan roti dan kue di sini</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-pink-50 text-pastel-dark px-3 md:px-4 py-2 rounded-xl font-bold text-xs md:text-sm border border-pink-100">
                    <span class="hidden md:inline">Total: </span>{{ $produks->count() }}
                </div>
                <button onclick="bukaModalTambah()" class="bg-pastel-dark text-white px-4 py-2 rounded-xl font-bold text-xs md:text-sm shadow-lg hover:bg-pink-700 transition flex items-center gap-2">
                    <i class="ph ph-plus-circle text-lg"></i>
                    <span class="hidden md:inline">Tambah Produk</span>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-pastel-bg text-pastel-dark border-b border-pink-100">
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">No</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Nama Produk</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm">Harga</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-center">Sisa Stok</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-center">Status</th>
                                <th class="py-4 px-4 md:px-6 font-semibold text-sm text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        
                        @forelse($produks as $index => $produk)
                            <tr class="hover:bg-pink-50/50 transition duration-150 group">
                                <td class="py-4 px-4 md:px-6 font-medium text-gray-500">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-4 px-4 md:px-6 font-bold text-gray-700 flex items-center gap-3">
                                    @if($produk->gambar)
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-10 h-10 rounded-lg object-cover shadow-sm border border-gray-100">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center text-pastel-dark">
                                            <i class="ph ph-image"></i>
                                        </div>
                                    @endif
                                    {{ $produk->nama_produk }}
                                </td>
                                <td class="py-4 px-4 md:px-6 font-bold text-pastel-dark">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center font-bold text-gray-700">
                                    {{ $produk->stok }}
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center">
                                    @if($produk->stok > 10)
                                        <span class="bg-green-100 text-green-700 border border-green-200 text-xs font-bold px-3 py-1.5 rounded-full">
                                            Aman
                                        </span>
                                    @elseif($produk->stok > 0)
                                        <span class="bg-orange-100 text-orange-700 border border-orange-200 text-xs font-bold px-3 py-1.5 rounded-full">
                                            Hampir Habis
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 border border-red-200 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                            Habis!
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 md:px-6 text-center space-x-2">
                                    <button onclick="bukaModalEdit({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, {{ $produk->stok }}, {{ $produk->kategori_id }})" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded transition">
                                        <i class="ph ph-pencil-simple text-lg"></i>
                                    </button>
                                    <button onclick="konfirmasiHapus({{ $produk->id }})" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2 py-1 rounded transition">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                    <form id="form-hapus-{{ $produk->id }}" action="/stok/{{ $produk->id }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Belum ada data produk saat ini.</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>           
                </div>

            </div>
        </div>
        <div id="modal-form" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
            <div class="bg-white w-full max-w-md p-6 md:p-8 rounded-3xl shadow-2xl transform transition-transform scale-95" id="modal-content">
                <div class="flex justify-between items-center mb-6">
                    <h2 id="modal-title" class="text-xl font-bold text-gray-800">Tambah Produk Baru</h2>
                    <button onclick="tutupModal()" class="text-gray-400 hover:text-red-500 transition">
                        <i class="ph ph-x text-2xl"></i>
                    </button>
                </div>
    
                <form id="form-produk" method="POST" action="/stok" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Produk</label>
                            <input type="text" name="nama_produk" id="input-nama" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Harga (Rp)</label>
                                <input type="number" name="harga" id="input-harga" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Jumlah Stok</label>
                                <input type="number" name="stok" id="input-stok" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300">
                            </div>
                        </div>
    
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Kategori</label>
                            <select name="kategori_id" id="input-kategori" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Foto Produk (Opsional)</label>
                            <input type="file" name="gambar" id="input-gambar" accept="image/*" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pastel-dark hover:file:bg-pink-100">
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        </div>
                    </div>
    
                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="tutupModal()" class="w-1/2 py-3 rounded-xl font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="w-1/2 py-3 rounded-xl font-bold text-white bg-pastel-dark hover:bg-pink-700 shadow-lg shadow-pink-200 transition">Simpan Data</button>
                    </div>
                </form>
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
        
        // Menampilkan Pesan Sukses dari Controller
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#be185d'
            });
        @endif

        const modalForm = document.getElementById('modal-form');
        const formProduk = document.getElementById('form-produk');
        const modalTitle = document.getElementById('modal-title');
        const formMethod = document.getElementById('form-method');

        function bukaModalTambah() {
            modalTitle.innerText = "Tambah Produk Baru";
            formProduk.action = "/stok"; // Arahkan ke route Store
            formMethod.value = "POST"; // Gunakan metode POST
            
            // Kosongkan form
            document.getElementById('input-nama').value = "";
            document.getElementById('input-harga').value = "";
            document.getElementById('input-stok').value = "";
            document.getElementById('input-kategori').value = "";

            modalForm.classList.remove('hidden');
        }

        function bukaModalEdit(id, nama, harga, stok, kategori_id) {
            modalTitle.innerText = "Edit Data Produk";
            formProduk.action = `/stok/${id}`; // Arahkan ke route Update
            formMethod.value = "PUT"; // Laravel butuh method PUT untuk update
            
            // Isi form dengan data yang sudah ada
            document.getElementById('input-nama').value = nama;
            document.getElementById('input-harga').value = harga;
            document.getElementById('input-stok').value = stok;
            document.getElementById('input-kategori').value = kategori_id;

            modalForm.classList.remove('hidden');
        }

        function tutupModal() {
            modalForm.classList.add('hidden');
        }

        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data produk yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, submit form hapus rahasia kita
                    document.getElementById(`form-hapus-${id}`).submit();
                }
            })
        }
    </script>
</body>
</html>