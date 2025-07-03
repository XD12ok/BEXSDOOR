@extends('layouts.app')

@section('content')

<div class=" grid md:grid-cols-2 gap-6 px-8 py-6">
    <!-- Product Image -->
    <div class="flex justify-center items-center w-full">
        @if ($product->image)
            <img src="data:image/jpeg;base64,{{ base64_encode($product->image) }}" alt="Produk Image" style="width: 200px;" class="w-full h-auto object-contain max-w-md transform scale-100 md:scale-130 lg:scale-225">
        @endif
    </div>

    <!-- Product Info -->
    <div>
        <div class="text-sm text-gray-600  mt-4">
            Produk > {{$product->categories}} > {{$product->name}}
        </div>
        <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
        <div class="text-sm text-gray-600 mb-2">Views: {{$product->views}} •  {{ $product->sales }} Terjual</div>
        <div class="text-2xl font-bold text-green-700 mb-4">Rp.{{ number_format($product->price, 2) }}</div>
        <p class="text-sm text-gray-700 mb-4">
            {!! nl2br(e($product->description)) !!}
        </p>

        <!-- Quantity -->
        <div>
            <!-- FORM: Tambah ke Keranjang -->
            <form method="POST" action="{{ route('cart.add', $product->id) }}" id="form-basket">
                @csrf

                <!-- Quantity Input -->
                <!-- Quantity -->
                <div class="flex items-center gap-2 mb-4">
                    <button type="button" onclick="decrement(this)" class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600">−</button>
                    <input type="text" name="quantity" value="1" min="1" class="w-12 h-8 text-center border border-gray-300 rounded"/>
                    <button type="button" onclick="increment(this)" class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600">+</button>
                </div>


                <!-- Buttons -->
                <div class="flex flex-col gap-2">
                    <button type="submit" name="basket" class="px-8 py-2 rounded text-white bg-black hover:bg-gray-800">Tambah ke keranjang</button>
                </div>
            </form>

            <!-- FORM: Beli Sekarang -->
            <form method="POST" action="{{ route('cart.add', $product->id) }}" id="form-buy" class="mt-2">
                @csrf
                <input type="hidden" name="amount" id="buy-qty" value="1">
                <button type="submit" name="buy" class="w-full bg-green-600 text-white px-8 py-2 rounded hover:bg-green-700">Beli sekarang</button>
            </form>
        </div>

    @if(auth()->check() && auth()->user()->role === 'admin')
            <button><a href="{{ route('products.edit', $product->id) }}" class="px-6 py-2 rounded hover:bg-gray-800">Edit Produk</a></button>
        @endif


        <!-- Alasan Berbelanja -->
        <div class="mt-6">
            <h2 class="font-semibold mb-2">Alasan Berbelanja</h2>
            <ul class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                <li>Bisa bayar setelah pesanan sampai - COD</li>
                <li>Pesanan dapat dikirim di hari pemesanan</li>
                <li>Garansi uang kembali</li>
            </ul>
        </div>
    </div>
</div>

<!-- Deskripsi -->
<div class="px-8 py-4">
    <h2 class="text-lg font-semibold mb-2 text-center">informasi lainnya</h2>
    <div class="gap-4 text-sm text-gray-700">
        <div>
            <p class="text-gray-500"><strong>Warna</strong></p>
            <p><strong>{{$product->color}}</strong></p>

        </div>
        <br>
        <div>
            <p class="text-gray-500"><strong>SKU</strong></p>
            <p><strong>{{$product->SKU}}</strong></p>

        </div>
        <br>
        <div>
            <p class="text-gray-500"><strong>Categories</strong> </p>
            <p><strong>{{ $product->categories}}</strong></p>

        </div>
    </div>
</div>

<!-- Rekomendasi -->
<div class="px-8 py-7">
    <h2 class="text-lg font-semibold mb-4">Anda mungkin juga suka</h2>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 shadow">
        <!-- Produk rekomendasi -->
            @foreach($featuredProducts as $item)
                <x-product-card :product="$item" />
            @endforeach
    </div>
</div>

<a href="https://wa.me/628982115403" target="_blank"
   class="fixed bottom-5 right-5 z-50">
    <img src="/image/whatsapp.svg"
         alt="Chat via WhatsApp"
         class="w-14 h-14 rounded shadow-lg hover:opacity-80 transition" />
</a>

<script>
    function increment(button) {
        const input = button.previousElementSibling;
        let value = parseInt(input.value) || 1;
        input.value = value + 1;
    }

    function decrement(button) {
        const input = button.nextElementSibling;
        let value = parseInt(input.value) || 1;
        if (value > 1) {
            input.value = value - 1;
        }
    }

    function syncQty(value) {
        document.getElementById('buy-qty').value = value;
    }

    // Inisialisasi agar sinkron saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        const qty = document.getElementById('main-qty').value;
        syncQty(qty);
    });

</script>
@endsection
