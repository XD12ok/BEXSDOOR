<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>BEXSDOOR</title>

    <!-- Google Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" crossorigin="anonymous" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
          integrity="sha384-gAPqlBuTCdtVcYt9ocMOYWrnBZ4XSL6q+4eXqwNycOr4iFczhNKtnYhF3NEXJM51" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" integrity="sha384-cxOPjt7s7Iz04uaHJceBmS+qpjv2JkIHNVcuOrM+YHwZOmJGBXI00mdUXEq65HTH" crossorigin="anonymous"></script>

    <!-- Vite CSS -->
    @vite('resources/css/app.css')

    <!-- Custom Map Styling -->
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="bg-black shadow px-4 py-3 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto gap-1 flex justify-between items-center">

        <a href="{{ route('home') }}">
            <img src="/image/logos-removebg-preview 1.png" class="h-auto w-auto object-contain scale-110 mt-1">
        </a>

        <ul class="flex gap-4 text-sm text-white">
            <li><a href="{{ route('aboutUs') }}" class="hover:underline hidden md:flex">Tentang</a></li>
            <li><a href="{{ route('products.search') }}" class="hover:underline">Product</a></li>
        </ul>

        <form action="{{ route('products.search') }}" method="GET" class="w-full mx-2">
            <input type="text" name="search" placeholder="Cari produk..."
                   class="w-full h-[35px] pl-2 mx-2 rounded-b-lg rounded-t-lg bg-white">
        </form>

        <div class="flex ml-2 gap-3">
            <a href="{{ route('userDashboard') }}" class="text-white">
                <span class="material-symbols-outlined">person</span>
            </a>
            <a href="{{ route('cart.index') }}" class="text-white">
                <span class="material-symbols-outlined">shopping_cart</span>
            </a>
        </div>

        @guest
            <div class="hidden md:flex ml-2 gap-3">
                <a href="{{ route('login') }}"
                   class="inline-block bg-gray-800 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-gray-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="inline-block bg-emerald-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-emerald-500 transition">
                    Register
                </a>
            </div>
        @endguest
    </div>
</nav>

<main>
    @yield('content')
</main>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"
        integrity="sha384-2UI1PfnXFjVMQ7/ZDEF70CR943oH3v6uZrFQGGqJYlvhh4g6z6uVktxYbOlAczav"
        crossorigin="anonymous" defer></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha384-cxOPjt7s7Iz04uaHJceBmS+qpjv2JkIHNVcuOrM+YHwZOmJGBXI00mdUXEq65HTH"
        crossorigin="anonymous" defer></script>

<!-- Swiper Init -->
<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper('.heroSwiper', {
            loop: true,
            autoplay: { delay: 5000 },
        });
    });
</script>

<!-- Vite JS -->
@vite('resources/js/app.js')

@stack('scripts')
</body>
</html>
