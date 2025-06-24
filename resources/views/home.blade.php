	@extends('layouts.app')

@section('content')

    <div class="w-full max-w-6xl mx-auto">
        <div class="swiper heroSwiper my-8 h-[38vh] sm:h-[40vh] md:h-[400px]">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/image/carousel/Group 70.png" class="drop-shadow-lg h-full w-full object-cover" alt="Hero 1">
                </div>
                <div class="swiper-slide">
                    <img src="/image/carousel/Group 71.png" class="drop-shadow-lg h-full w-full object-cover" alt="Hero 2">
                </div>
                <div class="swiper-slide">
                    <img src="/image/carousel/Group 72.png" class="drop-shadow-lg h-full w-full object-cover" alt="Hero 3">
                </div>
            </div>
        </div>
    </div>


    {{-- Kategori --}}
    <section class="max-w-7xl mx-auto py-6 px-4">
            <h2 class="text-xl font-semibold mb-4">Categories</h2>

            <!-- Pembungkus scroll -->
            <div class="overflow-x-auto">
                <!-- Baris item kategori -->
                <div class="flex gap-4 w-max">
                    <a href="{{ route('products.search', ['categories' => 'Nata Series']) }}" class="min-w-[160px]">
                        <x-category-card title="Nata Series" image="/image/categories/nata.png"/>
                    </a>
                    <a href="{{ route('products.search', ['categories' => 'Hogma Series']) }}" class="min-w-[160px]">
                        <x-category-card title="Hogma Series" image="/image/categories/hogma.png"/>
                    </a>
                    <a href="{{ route('products.search', ['categories' => 'Yaza Series']) }}" class="min-w-[160px]">
                        <x-category-card title="Yaza Series" image="/image/categories/yaza.png"/>
                    </a>
                    <a href="{{ route('products.search', ['categories' => 'PVC']) }}" class="min-w-[160px]">
                        <x-category-card title="PVC" image="/image/categories/pvc.png"/>
                    </a>
                    <a href="{{ route('products.search', ['categories' => 'Glass']) }}" class="min-w-[160px]">
                        <x-category-card title="Glass" image="/image/categories/glass.png"/>
                    </a>
                </div>
            </div>
        </section>
    {{-- Produk Unggulan --}}
    <section class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-xl font-semibold mb-2">Product Unggulan</h2>
        <p class="text-sm text-gray-600 mb-4">Produk yang menarik dan paling banyak diminati</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </section>

    {{-- New Product --}}
    <section class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-xl font-semibold mb-2">New Product</h2>
        <p class="text-sm text-gray-600 mb-4">Temukan pintu impian rumah anda</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($newProducts as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>
    </section>

    <section class="max-w-2xl mx-auto text-center py-10 px-4">
        <h2 class="text-xl font-semibold mb-4">Kontak Kami</h2>
        <p class="text-gray-700 mb-6">
            Feel free to contact us with any question or concern. You can use the form on our
            website or email us directly. We appreciate your interest and look forward to
            hearing from you.
        </p>

        <div class="space-y-6 text-gray-800">
            <div>
                <h3 class="font-semibold">Email</h3>
                <p>bexsdoor@gmail.com</p>
            </div>

            <div>
                <h3 class="font-semibold">Telepon</h3>
                <p>+628123456789</p>
            </div>

            <div>
                <h3 class="font-semibold">Alamat</h3>
                <p>
                    Lamper Tengah X No 8 RT 01 RW 08 Lamper Tengah, Semarang<br />
                    Selatan, Kota Semarang 50248
                </p>
            </div>
        </div>
    </section>


    <div class="max-w-7xl mx-auto py-6 px-4">
        <h4 class="font-semibold mb-2">Location</h4>
        <div id="map" class="z-40"></div>
    </div>

    <hr class="mt-8">

    {{-- Footer Kontak --}}
    <footer class="bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-semibold mb-2">Contact Us</h4>
                <p class="text-sm">Email: bessxdoor@gmail.com</p>
                <p class="text-sm">Phone: +628223456789</p>
                <p class="text-sm">Alamat: Lamper Tengah X No 8 RT 01 RW 08, Semarang</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Socials</h4>
                <div class="flex gap-2">
                <a href="#"><img src="image/instagram.svg" class="" alt="instagram"></a>
                <a href="#"><img src="image/facebook.svg" class="" alt="facebook"></a>
                <a href="#"><img src="image/tiktok.svg" class="w-[24px] h-[24px]" alt="tiktok"></a>
                </div>
            </div>
            <div>
                <br>
                <div class="flex gap-3">
                    <a href="#"><img src="/image/bca.svg" class="h-6 scale-200 mr-3 mt-2" alt="BCA"></a>
                    <a href="#"><img src="/image/mandiri.svg" class="h-6 mb-3" alt="Mandiri"></a>
                    <a href="#"><img src="/image/qris.svg" class="h-6 mt-2" alt="QRIS"></a>
                    <p>by</p>
                    <a href="#"><img src="/image/midtrans.svg" class="h-6 mt-2" alt="midtrans"></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Tombol WhatsApp Mengambang -->
    <a href="https://wa.me/628982115403" target="_blank"
       class="fixed bottom-5 right-5 z-50">
        <img src="/image/whatsapp.svg"
             alt="Chat via WhatsApp"
             class="w-14 h-14 rounded shadow-lg hover:opacity-80 transition" />
    </a>


    <script>
        const tokoLat = -7.003293;
        const tokoLng = 110.444766;

        const map = L.map('map', {
            scrollWheelZoom: false
        }).setView([tokoLat, tokoLng], 15);

        // Tambahkan layer peta (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker di lokasi toko dengan popup info
        const marker = L.marker([tokoLat, tokoLng]).addTo(map);
        marker.bindPopup("<b>Toko Saya</b><br>Ini adalah lokasi toko saya.").openPopup();
    </script>

@endsection
