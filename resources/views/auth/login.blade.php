<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BEXSDOOR Login</title>
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
            <h1 class="text-2xl font-bold">Sign In</h1>
        </div>

        <!-- Form -->
        <form action= "" method="POST" class="w-full max-w-sm space-y-3">
            @csrf
            <a href="{{ url('/auth/google') }}">
                <button type="button" class="w-full border border-gray-300 py-2 rounded-md flex items-center justify-center space-x-2 hover:bg-gray-100">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5"/>
                    <span class="text-sm">Continue with Google</span>
                </button>
            </a>

            <!-- Or separator -->
            <div class="flex items-center space-x-2 text-gray-400 text-sm">
                <div class="flex-1 h-px bg-gray-300"></div>
                <span>Or</span>
                <div class="flex-1 h-px bg-gray-300"></div>
            </div>
            <input type="email" placeholder="E-mail"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300" name="email" value="{{old('email')}}"/>
            <input type="password" placeholder="Password"
                   class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-300" name="password"/>

            <div class="flex items-start text-xs text-gray-600">
                <input type="checkbox" class="mr-2 mt-1" name="checkbox"/>
                <span>Saya menyetujui <a href="#" class="text-orange-300">ketentuan layanan</a> dan <a href="#" class="text-orange-300">kebijakan privasi</a></span>
            </div>

            <button type="submit"
                    class="w-full bg-neutral-700 text-white py-2 rounded-md hover:bg-neutral-800 transition">
                Login
            </button>

            <div class="text-center text-sm">
                Don't have an account? <a href="{{route ('register') }}" class="text-blue-500">Sign up</a>
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
