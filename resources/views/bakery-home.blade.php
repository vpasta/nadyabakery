<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nadya Bakery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-bg text-dark">

    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-14 h-14 block">
                    <span class="font-bold text-primary text-xl">Nadya Bakery</span>
                </div>

                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="#" class="text-primary hover:text-secondary transition">Beranda</a>
                    <a href="#" class="text-gray-500 hover:text-primary transition">Menu</a>
                    <a href="#" class="text-gray-500 hover:text-primary transition">Kontak</a>
                    <a href="{{ url('kasir') }}" class="text-gray-500 hover:text-primary transition">Kasir</a>
                </div>

                <a href="#" class="hidden md:block bg-primary text-white px-6 py-2 rounded-full hover:bg-secondary transition shadow-lg shadow-primary-soft">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-4">
        <div class="max-w-6xl mx-auto flex flex-col-reverse md:flex-row items-center">
            
            <div class="md:w-1/2 text-center md:text-left mt-10 md:mt-0">
                <span class="bg-white text-primary px-4 py-1.5 rounded-full text-sm font-bold shadow-sm mb-6 inline-block">
                    ✨ Fresh from the Oven
                </span>
                <h1 class="text-4xl md:text-6xl font-bold text-dark leading-tight mb-6">
                    Rasakan Kelembutan <span class="text-primary">Roti & Kue</span> Spesial
                </h1>
                <p class="text-lg text-gray-500 mb-8 max-w-lg mx-auto md:mx-0">
                    Dibuat dengan cinta dan bahan-bahan premium. Nikmati momen manis harimu bersama varian bakery terbaik kami.
                </p>
                <div class="flex flex-col sm:flex-row justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="bg-primary text-white px-8 py-3 rounded-full font-semibold hover:bg-secondary transition shadow-lg shadow-primary-soft">
                        Lihat Menu
                    </a>
                    <a href="#" class="bg-white text-primary border border-primary-soft px-8 py-3 rounded-full font-semibold hover:bg-bg transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center relative">
                <div class="absolute bg-primary-soft rounded-full w-72 h-72 blur-3xl opacity-70 -z-10 top-10"></div>
                <img src="https://images.unsplash.com/photo-1519340333755-56e9c1d04579?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                     alt="Kue Strawberry yang lezat" 
                     class="rounded-3xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500 w-80 md:w-96 object-cover border-4 border-white">
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-dark mb-2">Favorit Pelanggan</h2>
                <p class="text-gray-500">Pilihan manis yang paling banyak dicari minggu ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-primary-soft">
                    <img src="https://images.unsplash.com/photo-1614707267537-b85aaf00c4b7?auto=format&fit=crop&w=400&q=80" alt="Croissant" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2 text-dark">Butter Croissant</h3>
                    <p class="text-gray-500 text-sm mb-4">Renyah di luar, lembut di dalam dengan mentega premium.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-secondary font-bold text-xl">Rp 25.000</span>
                        <button class="w-10 h-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary hover:text-white transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-primary-soft">
                    <img src="https://images.unsplash.com/photo-1587668178277-295251f900ce?auto=format&fit=crop&w=400&q=80" alt="Cupcake" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2 text-dark">Strawberry Cupcake</h3>
                    <p class="text-gray-500 text-sm mb-4">Cupcake vanila dengan frosting stroberi segar.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-secondary font-bold text-xl">Rp 18.000</span>
                        <button class="w-10 h-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary hover:text-white transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-bg rounded-2xl p-6 hover:-translate-y-2 transition duration-300 shadow-sm border border-primary-soft">
                    <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=400&q=80" alt="Cheesecake" class="w-full h-48 object-cover rounded-xl mb-4">
                    <h3 class="text-xl font-bold mb-2 text-dark">Blueberry Cheesecake</h3>
                    <p class="text-gray-500 text-sm mb-4">Cheesecake lumer dengan topping selai blueberry asli.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-secondary font-bold text-xl">Rp 35.000</span>
                        <button class="w-10 h-10 rounded-full bg-white text-primary flex items-center justify-center hover:bg-secondary hover:text-white transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-bg py-10 border-t border-primary-soft">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold text-primary mb-4">Nadya Bakery</h2>
            <div class="flex justify-center space-x-6 mb-6 text-gray-500 font-medium">
                <a href="#" class="hover:text-secondary transition">Instagram</a>
                <a href="#" class="hover:text-secondary transition">Facebook</a>
                <a href="#" class="hover:text-secondary transition">WhatsApp</a>
            </div>
            <p class="text-gray-400 text-sm">&copy; 2026 Nadya Bakery. Dibuat dengan cinta & Laravel.</p>
        </div>
    </footer>

</body>
</html>