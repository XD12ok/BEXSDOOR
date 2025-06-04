@extends('layouts.app')

@section('content')
    <section class="flex justify-center mt-10">
        <div class="w-32 h-32 rounded-full border-4 border-yellow-500 shadow-md overflow-hidden flex items-center justify-center hover:scale-110 transition-transform duration-300 transform">
            <img src="/image/logo.55.54.jpeg" alt="Logo Bexsdoor"
                 class="max-w-3/4 max-h-3/4 object-contain" />
        </div>
    </section>

    <!-- Deskripsi Perusahaan -->
    <section class="max-w-2xl mx-auto mt-6 px-4 text-center border-gray-300 border p-4 shadow-md hover:scale-110 transition-transform duration-300 rounded-xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 ">Bexsdoor</h2>
        <p class="text-lg leading-relaxed">
            <strong>Bexsdoor</strong> adalah perusahaan pintu yang berasal dari <strong>Kota Semarang</strong>,
            didirikan pada tahun <strong>2024</strong>. Kami berdedikasi untuk menghasilkan <strong>pintu terbaik</strong>
            dengan <strong>desain yang mewah</strong> dan berkualitas tinggi.
            Mengutamakan keindahan dan kekuatan, Bexsdoor hadir untuk memenuhi kebutuhan hunian dan bangunan modern di seluruh Indonesia.
        </p>
    </section>
@endsection
