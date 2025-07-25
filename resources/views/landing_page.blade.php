<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bexsdoor</title>
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js" integrity="sha384-sr9b4Ux0WhAUGclJ0ym0FSY2zSOMmNSn0bP/SA0e6bNCrpn/5W3QL8mm+LdlQMKw" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="css/landing.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon"/>
    @vite('resources/css/app.css')

    <style>
        .clip-diagonal {
            clip-path: polygon(100% 0, 100% 0%, 40% 0%, 100% 100%);
        }

        @media (max-width: 768px) {
            .clip-diagonal {
                clip-path: polygon(100% 0, 100% 0%, 50% 0%, 100% 100%);
            }
        }

        @media (max-width: 480px) {
            .clip-diagonal {
                clip-path: polygon(100% 0, 100% 0%, 60% 0%, 100% 100%);
            }
        }
    </style>
</head>
<body class="h-screen w-full bg-black relative text-white">
<div class="absolute top-0 left-0 w-full h-full bg-white z-0 clip-diagonal"></div>
<header class="relative w-full  p-4 z-10">
    <div class=" p-4 flex items-center justify-between md:justify-start rounded-2xl gap-4 fixed w-full py-4 z-20 -ml-5">
        <div class="mr-4">
            <a href="{{route('home')}}"><img src="image/logos-removebg-preview 1.png" alt="logo" class="w-16"></a>
        </div>
        <nav class="hidden md:flex space-x-8 mr-4 ">
            <a href="{{route('aboutUs')}}" class="hover:text-yellow-500">Tentang</a>
            <a href="{{route('products.search')}}" class="hover:text-yellow-500">Produk</a>
        </nav>

        <div class="flex-1 md:mx-4 hidden md:flex w-full">
            <form action="{{ route('products.search') }}" method="GET" class="w-full">
                <input type="text" placeholder="Search Product"
                       class="w-full px-4 py-2 rounded-md border border-gray-500 text-white shadow-xl">
            </form>
        </div>
        <div class="hidden md:flex space-x-4">
        @auth
            <a href="{{route('userDashboard')}}" class="text-black"> <span class="material-symbols-outlined">
                person</span></a>
            <a href="{{route('cart.index')}}" class="text-black">
                <span class="material-symbols-outlined">
                    shopping_cart</span>
            </a>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="bg-gray-500 text-white px-2 py-1 rounded hover:bg-black-500">
                Login
            </a>
            <a href="{{route('register')}}"
               class="bg-green-600 text-white px-2 py-1 rounded hover:bg-gray-500">Register</a>
        @endguest
        <div class="md:hidden">
            <button id="menu-2button" class="text-black text-2xl focus:outline-none z-10">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        </div>
        <div class="md:hidden">
            <button id="menu-button" class="text-black text-2xl focus:outline-none z-20">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <nav id="menu" class="hidden md:block w-full bg-black text-white rounded-lg shadow-lg md:mt-2 z-50 absolute top-20 left-0">
        {{-- Search --}}
        <div class="px-4 py-2">
            <input
                type="text"
                placeholder="Search Product"
                class="w-full px-4 py-2 rounded-md border border-gray-300 text-black"
            />
        </div>

        <hr class="border-gray-600">

        {{-- Authenticated Links --}}
        @auth
            <div class="flex flex-col md:flex-row items-start md:items-center px-4 py-2 gap-2">
                <a href="{{ route('userDashboard') }}" class="flex items-center gap-1 text-white hover:text-gray-300">
                    <span class="material-symbols-outlined">person</span> Dashboard
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center gap-1 text-white hover:text-gray-300">
                    <span class="material-symbols-outlined">shopping_cart</span> Cart
                </a>
            </div>
        @endauth

        {{-- Guest Links --}}
        @guest
            <div class="flex flex-col md:flex-row px-4 py-2 gap-2">
                <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 text-center">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-gray-600 text-center">
                    Register
                </a>
            </div>
        @endguest

        <hr class="border-gray-600">

        {{-- Main Navigation --}}
        <div class="flex flex-col px-4 py-2 gap-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2 hover:bg-gray-700 px-4 py-2 rounded">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('aboutUs') }}" class="flex items-center gap-2 hover:bg-gray-700 px-4 py-2 rounded">
                <i class="fas fa-info-circle"></i> Tentang
            </a>
            <a href="{{ route('products.search') }}" class="flex items-center gap-2 hover:bg-gray-700 px-4 py-2 rounded">
                <i class="fas fa-door-open"></i> Produk
            </a>
        </div>
    </nav>

    <section class="relative h-screen flex flex-col-reverse md:flex-row items-center justify-center">

        <div class="absolute inset-0 clip-diagonal"></div>

        <div class="relative z-10 md:p-1 lg:p-20 w-full  md:w-1/2 max-w-screen-2xl flex flex-col
    items-start border-l-2  pl-6 md:pl-20 lg:pl-10 text-white">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight md:text-left">
                Get <span class="text-yellow-500">YOUR</span> Dream <br/>
                <span class="text-yellow-500">DOOR</span> Now
            </h1>
            <p class="mt-4 text-md md:text-lg lg:text-xl leading-relaxed  md:text-left">
                Browse our exclusive collection <br class="md:inline"/>
                and discover the perfect door <br class="md:inline"/>
                for your home.
            </p>
            <a href="{{route('home')}}"
               class="mt-6 px-10 py-2 bg-white text-black font-semibold rounded transition duration-300 hover:bg-yellow-500">
                Buy Now
            </a>
        </div>

        <model-viewer
            src="image/pintu77.glb"
            class=" items-center relative w-full md:w-1/3 sm:w-1/3 h-[250px] sm:h-[300px] md:h-[350px] lg:h-[400px] "
            camera-controls
            shadow-intensity="1"
            auto-rotate
            shadow-softness="1"
            exposure="1"
            environment-image="https://modelviewer.dev/shared-assets/environments/neutral.hdr"
            style="background: transparent;">
        </model-viewer>

    </section>

    </section>


    <section class="relative w-full z-0  bg-black text-white py-10 text-center">
        <h2 class="text-2xl font-bold">Kenapa Memilih Pintu Kami?</h2>
        <p class="text-base mt-4 max-w-2xl mx-auto leading-relaxed">
            Kami menawarkan pintu dengan desain inovatif, bahan premium, dan harga kompetitif.
        </p>
    </section>
</header>
<script>
    document.getElementById("menu-button").addEventListener("click", function () {
        const menu = document.getElementById("menu");
        menu.classList.toggle("hidden");
        this.setAttribute("aria-expanded", menu.classList.contains("hidden") ? "false" : "true");
    });
</script>
</body>
</html>
