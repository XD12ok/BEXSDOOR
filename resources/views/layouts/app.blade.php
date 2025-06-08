<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>BEXSDOOR - Peta Lokasi Toko</title>

    <!-- Google Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" integrity="sha384-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

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

<!-- Konten halaman di sini -->

<!-- Swiper JS (bisa di-defer untuk performa) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="" defer></script>

@vite('resources/js/app.js')

</body>
</html>


{{-- Navbar sederhana --}}
<nav class="bg-black shadow px-4 py-3 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto gap-2 flex justify-between items-center">

        <a href="{{route('home')}}"><img src="/image/logos-removebg-preview 1.png" class="h-[40px] w-full scale-120 mt-1"></a>

        <ul class="flex gap-4 text-sm text-white">
            <li><a href="{{route('aboutUs')}}" class="hover:underline">Tentang</a></li>
            <li><a href="{{route('products.search')}}" class="hover:underline">Product</a></li>

        </ul>
        <form action="{{ route('products.search') }}" method="GET" class="w-full mx-2 ">
            <input type="text"  name="search" placeholder="Cari produk..."
                   class="w-full h-[35px] pl-2 mx-2 rounded-b-lg rounded-t-lg bg-white">
        </form>
        @auth
            <a href="{{route ('userDashboard')}}" class="text-white"> <span class="material-symbols-outlined">
                person</span></a>
            <a href="{{route('cart.index')}}" class="text-white">
                <span class="material-symbols-outlined">
                    shopping_cart</span>
            </a>
        @endauth

        @guest
            <div class="flex gap-3">
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

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.heroSwiper', {
        loop: true,
        autoplay: {delay: 5000},
    });
</script>
@stack('scripts')
</body>
</html>

