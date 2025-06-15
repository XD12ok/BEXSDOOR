@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Daftar Produk (Kiri) -->
            <div class="md:col-span-3 order-1 md:order-1">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-7">
                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full text-gray-500">Tidak ada produk ditemukan.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>

            <!-- Sidebar Filter (Kanan) -->
            <div class="md:col-span-1 order-2 md:order-2 flex flex-col gap-6 sticky top-20">

                <!-- Filter Urutkan -->
                <div class="border rounded shadow p-4 bg-white">
                    <form method="GET" id="filterFormSort" class="flex flex-col">
                        <label class="font-semibold">Urutkan Berdasarkan:</label>
                        <hr class="my-2">
                        <div class="flex flex-col gap-1">
                            @foreach(['populer', 'terlaris', 'terbaru'] as $sort)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="sort" value="{{ $sort }}"
                                           onchange="document.getElementById('filterFormSort').submit()"
                                           {{ request('sort') === $sort ? 'checked' : '' }}
                                           class="form-radio text-black">
                                    <span class="ml-2 capitalize">{{ $sort }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Kirim juga min & max & kategori saat sort berubah -->
                        <input type="hidden" name="price_min" value="{{ request('price_min', 0) }}">
                        <input type="hidden" name="price_max" value="{{ request('price_max', 10000000) }}">
                        <input type="hidden" name="categories" value="{{ request('categories') }}">
                    </form>
                </div>

                <!-- Filter Harga -->
                <div class="border rounded shadow p-4 bg-white">
                    <form method="GET" id="filterFormHarga" class="flex flex-col gap-2">
                        <label class="font-semibold">Harga (Rp)</label>
                        <hr class="my-1">
                        <div class="flex justify-between text-sm text-gray-700 mb-2">
                            <span id="minPriceDisplay">Rp{{ number_format(request('price_min', 0), 0, ',', '.') }}</span>
                            <span id="maxPriceDisplay">Rp{{ number_format(request('price_max', 10000000), 0, ',', '.') }}</span>
                        </div>

                        <input type="range" name="price_min" id="price_min"
                               min="0" max="10000000" step="100000"
                               value="{{ request('price_min', 0) }}"
                               onchange="document.getElementById('filterFormHarga').submit()"
                               oninput="updateSliderDisplay()"
                               class="w-full">

                        <input type="range" name="price_max" id="price_max"
                               min="0" max="10000000" step="100000"
                               value="{{ request('price_max', 10000000) }}"
                               onchange="document.getElementById('filterFormHarga').submit()"
                               oninput="updateSliderDisplay()"
                               class="w-full mt-2">

                        <!-- Kirim juga sort & kategori saat harga berubah -->
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="categories" value="{{ request('categories') }}">
                    </form>
                </div>

                <!-- Filter Kategori -->
                @php
                    $categoriesList = ['Nata Series', 'Yaza Series', 'Hogma Series', 'PVC', 'Glass'];
                @endphp

                <div class="md:col-span-1 order-2 md:order-3">
                    <div class="p-4 border rounded shadow bg-white">
                        <h2 class="font-semibold mb-2">Kategori Produk</h2>
                        <hr class="my-2">
                        <div class="flex flex-col gap-2">
                            @foreach ($categoriesList as $cat)
                                <a href="{{ route('products.index', array_merge(request()->query(), ['categories' => $cat])) }}"
                                   class="text-sm px-3 py-2 rounded {{ request('categories') === $cat ? 'bg-black text-white' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="https://wa.me/628982115403" target="_blank"
       class="fixed bottom-5 right-5 z-50">
        <img src="/image/whatsapp.svg"
             alt="Chat via WhatsApp"
             class="w-14 h-14 rounded shadow-lg hover:opacity-80 transition" />
    </a>

    @push('scripts')
        <script>
            function updateSliderDisplay() {
                const min = document.getElementById('price_min').value;
                const max = document.getElementById('price_max').value;

                document.getElementById('minPriceDisplay').innerText = 'Rp' + Number(min).toLocaleString('id-ID');
                document.getElementById('maxPriceDisplay').innerText = 'Rp' + Number(max).toLocaleString('id-ID');
            }

            document.addEventListener('DOMContentLoaded', updateSliderDisplay);
        </script>
    @endpush
@endsection
