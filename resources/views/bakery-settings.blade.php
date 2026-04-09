<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Nadya Bakery</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#F58E8B">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                <a href="/stok" class="flex items-center p-3 text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl transition">
                    <i class="ph ph-package text-2xl"></i>
                    <span class="ml-3 font-medium">Stok Produk</span>
                </a>
                <a href="/pengaturan" class="flex items-center p-3 text-white bg-primary rounded-xl shadow-lg' : 'text-gray-500 hover:bg-pink-50 hover:text-primary rounded-xl' }} transition">
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

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="md:hidden flex items-center justify-between bg-white p-4 shadow-sm border-b border-primary-soft">
            <span class="font-bold text-primary text-lg">Pengaturan</span>
            <button onclick="toggleSidebar()" class="text-gray-400"><i class="ph ph-list text-2xl"></i></button>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            <h1 class="text-2xl font-bold text-dark mb-6">Pengaturan Sistem</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-primary-soft">
                    <div class="flex items-center space-x-2 mb-6 text-primary">
                        <i class="ph ph-user-circle text-2xl"></i>
                        <h2 class="text-lg font-bold">Keamanan Akun</h2>
                    </div>
                    
                    <form action="{{ url('/pengaturan/profile') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Aktif</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Kosongkan jika tidak ganti)</label>
                            <input type="password" name="password" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-soft focus:outline-none">
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-secondary transition">Simpan Perubahan</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-primary-soft">
                    <div class="flex items-center space-x-2 mb-6 text-primary">
                        <i class="ph ph-qr-code text-2xl"></i>
                        <h2 class="text-lg font-bold">QRIS Pembayaran</h2>
                    </div>

                    <form action="{{ url('/pengaturan/qris') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                        @csrf
                        <div class="relative w-full aspect-square max-w-[250px] border-2 border-gray-300 border-dashed rounded-2xl bg-gray-50 overflow-hidden group mb-4">
                            <input type="file" name="qris_image" id="input-qris" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" onchange="previewQris(event)">
                            
                            <img id="preview-qris" src="{{ asset('storage/images/qris.png') }}?v={{ time() }}" class="absolute inset-0 w-full h-full object-cover z-10 {{ file_exists(storage_path('app/public/images/qris.png')) ? '' : 'hidden' }}">

                            <div id="teks-qris" class="flex flex-col items-center justify-center h-full z-0 {{ file_exists(storage_path('app/public/images/qris.png')) ? 'hidden' : '' }}">
                                <i class="ph ph-upload-simple text-4xl text-gray-400 mb-2"></i>
                                <span class="text-sm font-semibold text-gray-500 text-center px-4">Klik untuk ganti QRIS</span>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-secondary text-white py-3 rounded-xl font-bold hover:opacity-90 transition">Update Gambar QRIS</button>
                    </form>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center text-primary">
                            <i class="ph ph-tag text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Manajemen Kategori</h2>
                            <p class="text-sm text-gray-500">Kelola kategori produk roti Anda</p>
                        </div>
                    </div>
                    </div>
            
                <form action="{{ route('kategori.store') }}" method="POST" class="flex gap-3 mb-6">
                    @csrf
                    <input type="text" name="nama_kategori" placeholder="Nama kategori baru..." class="flex-1 px-4 py-2 rounded-xl border border-gray-200 outline-none focus:ring-2 focus:ring-primary-soft" required>
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:opacity-90 transition">Tambah</button>
                </form>
            
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-sm border-b border-gray-50">
                                <th class="pb-3 font-medium">Nama Kategori</th>
                                <th class="pb-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($kategori as $k)
                            <tr>
                                <td class="py-4 text-gray-700 font-medium">{{ $k->nama_kategori }}</td>
                                <td class="py-4 text-right flex justify-end space-x-2">
                                    <button onclick="editKategori({{ $k->id }}, '{{ $k->nama_kategori }}')" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition">
                                        <i class="ph ph-pencil-simple text-xl"></i>
                                    </button>
                                    
                                    <button onclick="konfirmasiHapus({{ $k->id }})"
                                        class="p-2 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                    
                                    <form id="form-hapus-{{ $k->id }}"
                                        action="{{ route('kategori.destroy', $k->id) }}"
                                        method="POST"
                                        class="hidden">
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

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        function previewQris(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('preview-qris').src = URL.createObjectURL(file);
                document.getElementById('preview-qris').classList.remove('hidden');
                document.getElementById('teks-qris').classList.add('hidden');
            }
        }

        function editKategori(id, namaLama) {
        Swal.fire({
            title: 'Edit Kategori',
            input: 'text',
            inputValue: namaLama,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            confirmButtonColor: '#2EC4B6',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) return 'Nama kategori tidak boleh kosong!'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form dinamis untuk submit PUT
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/pengaturan/kategori/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama_kategori" value="${result.value}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
        }

        function konfirmasiHapus(id) {
        Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data kategori yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`form-hapus-${id}`).submit();
            }
        })
}

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#2EC4B6' });
        @endif

        @if($errors->any())
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ $errors->first() }}", confirmButtonColor: '#2EC4B6' });
        @endif

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((registration) => {
                    console.log('PWA Service Worker berhasil didaftarkan!', registration.scope);
                }).catch((error) => {
                    console.log('PWA Service Worker gagal didaftarkan:', error);
                });
            });
        }
    </script>
</body>
</html>