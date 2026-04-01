const CACHE_NAME = 'nadya-pos-v1';

// Saat aplikasi pertama kali diinstal
self.addEventListener('install', (event) => {
    console.log('Service Worker: Terinstal');
    // Memaksa SW langsung aktif tanpa menunggu
    self.skipWaiting(); 
});

// Membersihkan cache lama jika ada update
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Aktif');
});

// Mencegat permintaan jaringan (Network First strategy agar data stok selalu baru)
self.addEventListener('fetch', (event) => {
    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(event.request);
        })
    );
});