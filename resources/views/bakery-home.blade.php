<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nadya Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#ffe4e6',    // Pink sangat muda
                        'pastel-dark': '#be185d',    // Pink tua untuk teks/tombol
                        'pastel-bg': '#fff1f2',      // Background halaman
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-pastel-bg text-gray-700">

    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-10 shadow-sm">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🧁</span>
                    <a href="#" class="text-2xl font-bold text-pastel-dark">Nadya Bakery</a>
                </div>

                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="#" class="text-pastel-dark hover:text-pink-400 transition">Beranda</a>
                    <a href="#" class="hover:text-pink-400 transition">Menu</a>
                    <a href="#" class="hover:text-pink-400 transition">Kontak</a>
                    <a href="{{ url('kasir') }}" class="hover:text-pink-400 transition">Kasir</a>
                </div>

                <a href="#" class="hidden md:block bg-pastel-dark text-white px-5 py-2 rounded-full hover:bg-pink-600 transition shadow-lg shadow-pink-200">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-4">
        <div class="max-w-6xl mx-auto flex flex-col-reverse md:flex-row items-center">
            
            <div class="md:w-1/2 text-center md:text-left mt-10 md:mt-0">
                <span class="bg-white text-pastel-dark px-3 py-1 rounded-full text-sm font-semibold shadow-sm mb-4 inline-block">
                    ✨ Fresh from the Oven
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-gray-800 leading-tight mb-6">
                    Rasakan Kelembutan <span class="text-pastel-dark">Roti & Kue</span> Spesial
                </h1>
                <p class="text-lg text-gray-500 mb-8">
                    Dibuat dengan cinta dan bahan-bahan premium. Nikmati momen manis harimu bersama varian bakery terbaik kami.
                </p>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="#" class="bg-pastel-dark text-white px-8 py-3 rounded-full font-semibold hover:bg-pink-600 transition shadow-lg shadow-pink-300">
                        Lihat Menu
                    </a>
                    <a href="#" class="bg-white text-pastel-dark border border-pink-200 px-8 py-3 rounded-full font-semibold hover:bg-pink-50 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center relative">
                <div class="absolute bg-pink-200 rounded-full w-72 h-72 blur-3xl opacity-50 -z-10 top-10"></div>
                <img src="https://images.unsplash.com/photo-1519340333755-56e9c1d04579?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                     alt="Kue Strawberry yang lezat" 
                     class="rounded-3xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500 w-80 md:w-96 object-cover">
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Favorit Pelanggan</h2>
                <p class="text-gray-500">Pilihan manis yang paling banyak dicari minggu ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-pastel-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-pink-100">
                    <img src="https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?auto=format&fit=crop&w=400&q=80" alt="Croissant" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2">Butter Croissant</h3>
                    <p class="text-gray-500 text-sm mb-4">Renyah di luar, lembut di dalam dengan mentega premium.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-pastel-dark font-bold text-lg">Rp 25.000</span>
                        <button class="w-8 h-8 rounded-full bg-white text-pastel-dark flex items-center justify-center hover:bg-pastel-dark hover:text-white transition">+</button>
                    </div>
                </div>

                <div class="bg-pastel-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-pink-100">
                    <img src="https://images.unsplash.com/photo-1587668178277-295251f900ce?auto=format&fit=crop&w=400&q=80" alt="Cupcake" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2">Strawberry Cupcake</h3>
                    <p class="text-gray-500 text-sm mb-4">Cupcake vanila dengan frosting stroberi segar.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-pastel-dark font-bold text-lg">Rp 18.000</span>
                        <button class="w-8 h-8 rounded-full bg-white text-pastel-dark flex items-center justify-center hover:bg-pastel-dark hover:text-white transition">+</button>
                    </div>
                </div>

                <div class="bg-pastel-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-pink-100">
                    <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=400&q=80" alt="Cheesecake" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2">Blueberry Cheesecake</h3>
                    <p class="text-gray-500 text-sm mb-4">Cheesecake lumer dengan topping selai blueberry asli.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-pastel-dark font-bold text-lg">Rp 35.000</span>
                        <button class="w-8 h-8 rounded-full bg-white text-pastel-dark flex items-center justify-center hover:bg-pastel-dark hover:text-white transition">+</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-pink-50 py-10 border-t border-pink-100">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-pastel-dark mb-4">Nadya Bakery</h2>
            <div class="flex justify-center space-x-6 mb-6 text-gray-600">
                <a href="#" class="hover:text-pastel-dark">Instagram</a>
                <a href="#" class="hover:text-pastel-dark">Facebook</a>
                <a href="#" class="hover:text-pastel-dark">WhatsApp</a>
            </div>
            <p class="text-gray-400 text-sm">&copy; 2026 Nadya Bakery. Dibuat dengan cinta & Laravel.</p>
        </div>
    </footer>

</body>
</html>