@props(['product'])

<a href="{{ route('products.show', ['id' => $product->id]) }}" class="block">
    <div class="border-gray rounded overflow-hidden shadow hover:shadow-lg transition bg-white">
        @if ($product->image)
            <img src="data:image/jpeg;base64,{{ base64_encode($product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                Tidak ada gambar
            </div>
        @endif
        <div class="p-2 justify-items-center">
            <h3 class="text-sm font-semibold">{{ $product->name }}</h3>
            <p class="text-xs text-gray-500">{{ $product->categories }}</p>
            <p class="text-sm font-light mt-1">Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
    </div>
</a>
