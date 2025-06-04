@props(['title', 'image'])

<div class="relative w-72 h-40 rounded-xl overflow-hidden shadow hover:shadow-md transition">
    <!-- Gambar -->
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">

    <!-- Label biru -->
    <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
        All products
    </div>

    <!-- Overlay hitam di bawah -->
    <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-3">
        <div class="text-white text-base font-semibold">
            {{ $title }}
        </div>
    </div>
</div>

