<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Stok Produk - Nadya Bakery</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F58E8B">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50 text-dark h-screen w-full flex overflow-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity" onclick="toggleSidebar()"></div>

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
                <a href="/riwayat" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-receipt text-2xl"></i>
                    <span class="ml-3 font-medium">Riwayat</span>
                </a>
                <a href="/stok" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg shadow-primary-soft transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
                <a href="/pengaturan" class="flex items-center p-3 {{ Request::is('pengaturan') ? 'text-white bg-primary rounded-xl shadow-lg' : 'text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl' }} transition">
                    <i class="ph ph-gear text-2xl"></i>
                    <span class="ml-3 font-medium">Pengaturan</span>
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

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative w-full">
        
        <header class="md:hidden flex items-center justify-between bg-white p-4 shadow-sm border-b border-primary-soft shrink-0">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-10 h-10 block">
                <span class="font-bold text-primary text-lg">Nadya Bakery</span>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500 transition">
                <i class="ph ph-list text-2xl"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-dark">Manajemen Stok</h1>
                    <p class="text-gray-500 mt-1">Kelola harga dan ketersediaan produk.</p>
                </div>
                <button onclick="bukaModalTambah()" class="bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-secondary transition flex items-center space-x-2 shadow-sm w-full sm:w-auto justify-center">
                    <i class="ph ph-plus-circle text-xl"></i>
                    <span>Tambah Produk</span>
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-primary-soft overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-150">
                        <thead>
                            <tr class="bg-bg text-gray-500 text-sm border-b border-primary-soft">
                                <th class="py-4 px-6 font-semibold w-16">No</th>
                                <th class="py-4 px-6 font-semibold">Produk</th>
                                <th class="py-4 px-6 font-semibold">Harga</th>
                                <th class="py-4 px-6 font-semibold text-center">Stok</th>
                                <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($produks as $index => $produk)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-gray-500">{{ $index + 1 }}</td>
                                
                                <td class="py-4 px-6 font-medium text-dark flex items-center space-x-3">
                                    @if($produk->gambar)
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-primary-soft flex items-center justify-center text-primary font-bold">
                                            {{ substr($produk->nama_produk, 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $produk->nama_produk }}</span>
                                </td>
                                <td class="py-4 px-6 font-bold text-secondary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $produk->stok > 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $produk->stok }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="bukaModalEdit({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, {{ $produk->stok }}, {{ $produk->kategori_id }})" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition">
                                            <i class="ph ph-pencil-simple text-lg"></i>
                                        </button>
                                        <button onclick="konfirmasiHapus({{ $produk->id }})" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition">
                                            <i class="ph ph-trash text-lg"></i>
                                        </button>
                                    </div>
                                    <form id="form-hapus-{{ $produk->id }}" action="{{ url('/stok/'.$produk->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="modal-form" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="tutupModal()"></div>
        
        <div class="bg-white rounded-2xl w-full max-w-md mx-4 z-10 shadow-2xl overflow-hidden transform transition-all border border-primary-soft">
            <div class="p-5 border-b border-primary-soft bg-bg flex justify-between items-center">
                <h3 id="modal-title" class="text-lg font-bold text-dark">Tambah Produk</h3>
                <button onclick="tutupModal()" class="text-gray-400 hover:text-primary transition"><i class="ph ph-x text-2xl"></i></button>
            </div>
            
            <form id="form-produk" action="{{ url('/stok') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="nama_produk" id="input-nama" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" id="input-harga" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stok" id="input-stok" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_id" id="input-kategori" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col items-center mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 w-full text-left">Upload Foto (Opsional)</label>
                    
                    <div class="relative flex flex-col items-center justify-center w-40 h-40 border-2 border-gray-300 border-dashed rounded-2xl bg-gray-50 hover:bg-gray-100 transition overflow-hidden group">
                        
                        <input type="file" name="gambar" id="input-gambar" accept="image/jpeg, image/png, image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewImage(event)">
                        
                        <img id="preview-gambar" src="" class="absolute inset-0 w-full h-full object-cover z-10 hidden" alt="Preview">

                        <div id="teks-upload" class="flex flex-col items-center justify-center z-0">
                            <i class="ph ph-image text-4xl text-gray-400 mb-2 group-hover:text-primary transition"></i>
                            <span class="text-sm font-semibold text-gray-500">Pilih Foto</span>
                            <span class="text-[10px] text-gray-400 mt-1">Rasio 1:1 (Maks 2MB)</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-gray-100 mt-6">
                    <button type="button" onclick="tutupModal()" class="px-5 py-2 rounded-xl text-gray-500 font-medium hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-secondary transition shadow-sm">Simpan</button>
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

        // Menampilkan Pesan Error Validasi dari Controller
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: '<ul class="text-left text-sm text-red-500">@foreach($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#be185d'
            });
        @endif

        const modalForm = document.getElementById('modal-form');
        const formProduk = document.getElementById('form-produk');
        const modalTitle = document.getElementById('modal-title');
        const formMethod = document.getElementById('form-method');

        function bukaModalTambah() {
            modalTitle.innerText = "Tambah Produk Baru";
            formProduk.action = "/stok"; 
            formMethod.value = "POST"; 
            
            // Reset input teks
            document.getElementById('input-nama').value = "";
            document.getElementById('input-harga').value = "";
            document.getElementById('input-stok').value = "";
            document.getElementById('input-kategori').value = "";

            // Reset input gambar dan preview dengan aman
            const inputGambar = document.getElementById('input-gambar');
            const previewGambar = document.getElementById('preview-gambar');
            const teksUpload = document.getElementById('teks-upload');

            if(inputGambar) inputGambar.value = ""; 
            if(previewGambar) {
                previewGambar.src = ""; 
                previewGambar.classList.add('hidden');
            }
            if(teksUpload) teksUpload.classList.remove('hidden');

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

            const inputGambar = document.getElementById('input-gambar');
            const previewGambar = document.getElementById('preview-gambar');
            const teksUpload = document.getElementById('teks-upload');

            if(inputGambar) inputGambar.value = ""; 
            if(previewGambar) {
                previewGambar.src = ""; 
                previewGambar.classList.add('hidden');
            }
            if(teksUpload) teksUpload.classList.remove('hidden');

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
        
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((registration) => {
                    console.log('PWA Service Worker berhasil didaftarkan!', registration.scope);
                }).catch((error) => {
                    console.log('PWA Service Worker gagal didaftarkan:', error);
                });
            });
        }

        // Fungsi untuk menampilkan preview gambar dan validasi ukuran
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-gambar');
            const teks = document.getElementById('teks-upload');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validasi Ukuran File (Maksimal 2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    // Munculkan notifikasi error
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran Terlalu Besar!',
                        text: 'Maksimal ukuran foto adalah 2MB.',
                        confirmButtonColor: '#be185d'
                    });
                    
                    // Reset input agar file batal dipilih
                    input.value = "";
                    preview.src = "";
                    preview.classList.add('hidden');
                    teks.classList.remove('hidden');
                    
                    return; // Hentikan eksekusi kode di sini
                }

                // Jika ukuran aman, lanjut tampilkan preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); 
                    teks.classList.add('hidden'); 
                }
                reader.readAsDataURL(file);
            } else {
                // Jika user batal memilih file
                preview.src = "";
                preview.classList.add('hidden');
                teks.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>