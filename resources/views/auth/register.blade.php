<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BEXSDOOR REGISTER</title>
    <link rel="icon" href="" type="image/x-icon">
    @vite('resources/css/app.css')
</head>
<body class="h-screen w-screen overflow-hidden font-sans">
<div class="flex h-full">
    <!-- Kiri: Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-4">
        <!-- Back button -->
        <div class="absolute top-4 left-4">
            <button onclick="window.history.back()">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="image/logo.55.54.jpeg" alt="Logo" class="mx-auto w-32 mb-2"/>
            <h1 class="text-2xl font-bold">Sign Up</h1>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('registerProcess') }}" class="w-full max-w-sm space-y-3">
        @csrf
            <input type="email" placeholder="E-mail" name="email"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300"/>
            <input type="text" placeholder="Username" name="name"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300"/>
            <input type="password" placeholder="Password" name="password"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300"/>
            <input type="password" placeholder="Confirm Password" name="password_confirmation"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300"/>

            <div class="flex items-start text-xs text-gray-600">
                <input type="checkbox" name="checkbox" class="mr-2 mt-1"/>
                <span>Saya menyetujui <a href="#" class="text-orange-300">ketentuan layanan</a> dan <a href="#" class="text-orange-300">kebijakan privasi</a></span>
            </div>

            <button type="submit"
                    class="w-full bg-neutral-700 text-white py-2 rounded-md hover:bg-neutral-800 transition">
                Register
            </button>

            <div class="text-center text-sm">
                have an account? <a href="{{route ('login')}}" class="text-blue-500">Sign in</a>
            </div>
            @if($errors -> any())
                <div class="alert text-[#FF0000]">
                    <ul>
                        @foreach($errors->all() as $item)
                            <li>{{$item}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    <!-- Kanan: Background Gambar -->
    <div class="hidden md:flex w-1/2 h-full">
        <img src="image/gambar_pintu_banyak.png" alt="Background" class="object-cover w-full h-full" />
    </div>
</div>
</body>
</html>
