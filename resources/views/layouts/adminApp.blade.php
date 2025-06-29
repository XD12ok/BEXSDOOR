<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>BEXSDOOR</title>

    <!-- Google Fonts: Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- App CSS via Vite -->
    @vite('resources/css/app.css')

    <!-- Chart.js + jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
</head>

<body class="bg-[#fef9f4]">
<!-- Mobile Sidebar Toggle Button -->
<div class="md:hidden fixed top-4 left-4 z-50">
    <button id="sidebarToggle" class="text-white bg-[#89652f] p-2 rounded focus:outline-none">
        ☰
    </button>
</div>


<!-- Sidebar -->
<aside id="sidebar"
       class="fixed top-0 left-0 bottom-0 w-64 bg-[#89652f] text-white p-4 flex flex-col h-screen z-40
    transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out
    overflow-y-auto">

    <div class="mb-8 flex items-center gap-2">
        <img src="/image/logos-removebg-preview 1.png" alt="Logo" class="w-40" />
    </div>

    <nav class="flex-1 space-y-6">
        <a href="/home"
           class="block py-2 px-4 rounded {{ Request::is('home') ? 'bg-[#64502a]' : 'hover:bg-[#a77c37]' }}">
            BEXSDOOR
        </a>
        <a href="/admin/dashboard"
           class="block py-2 px-4 rounded {{ Request::is('admin/dashboard') ? 'bg-[#64502a]' : 'hover:bg-[#a77c37]' }}">
            Dashboard
        </a>
        <a href="/admin/products"
           class="block py-2 px-4 rounded {{ Request::is('admin/products') ? 'bg-[#64502a]' : 'hover:bg-[#a77c37]' }}">
            Produk
        </a>
        <a href="/orders"
           class="block py-2 px-4 rounded {{ Request::is('orders*') ? 'bg-[#64502a]' : 'hover:bg-[#a77c37]' }}">
            Pesanan
        </a>
        <a href="/admin/transaksi"
           class="block py-2 px-4 rounded {{ Request::is('admin/transaksi') ? 'bg-[#64502a]' : 'hover:bg-[#a77c37]' }}">
            Transaksi
        </a>
    </nav>
</aside>

<!-- Main Content -->
<main class="p-4 transition-all duration-300 md:ml-64">
    @yield('content')
</main>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

<!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', () => {
        const isOpen = !sidebar.classList.contains('-translate-x-full');

        // Toggle sidebar visibility
        sidebar.classList.toggle('-translate-x-full');

        // Sembunyikan tombol saat sidebar dibuka
        if (!isOpen) {
        toggleBtn.classList.add('hidden');
    }

        // Deteksi klik di luar sidebar (untuk close dan tampilkan tombol lagi)
        const handleClickOutside = (e) => {
        if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
        sidebar.classList.add('-translate-x-full');
        toggleBtn.classList.remove('hidden');
        document.removeEventListener('click', handleClickOutside);
    }
    };

        setTimeout(() => {
        document.addEventListener('click', handleClickOutside);
    }, 10); // delay agar klik tombol tidak langsung trigger close
    });
    });
</script>
</body>
</html>
