@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <!-- Tombol Filter (Mobile) -->
        <div class="md:hidden mb-4 flex justify-end">
            <button onclick="openFilterPopup()" class=" px-3 py-1 bg-black text-white rounded-4xl shadow hover:bg-gray-800 transition">
                <span class="material-symbols-outlined pt-2">
                    tune
                </span>
            </button>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Produk -->
            <div class="md:col-span-3">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
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

            <!-- Sidebar Filter (Desktop Only) -->
            <div class="hidden md:flex md:flex-col gap-6 sticky top-20">

                <!-- Urutkan -->
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
                        <input type="hidden" name="price_min" value="{{ request('price_min', 0) }}">
                        <input type="hidden" name="price_max" value="{{ request('price_max', 10000000) }}">
                        <input type="hidden" name="categories" value="{{ request('categories') }}">
                    </form>
                </div>

                <!-- Harga -->
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
                               oninput="updateSliderDisplay()">
                        <input type="range" name="price_max" id="price_max"
                               min="0" max="10000000" step="100000"
                               value="{{ request('price_max', 10000000) }}"
                               onchange="document.getElementById('filterFormHarga').submit()"
                               oninput="updateSliderDisplay()" class="mt-2">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="categories" value="{{ request('categories') }}">
                    </form>
                </div>

                <!-- Kategori -->
                @php
                    $categoriesList = ['Nata Series', 'Yaza Series', 'Hogma Series', 'PVC', 'Glass'];
                @endphp
                <div class="border rounded shadow p-4 bg-white">
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

    <!-- Popup Filter (Mobile) -->
    <div id="filterPopup" class="fixed inset-0 z-50 bg-black/40 flex items-end md:hidden" onclick="closeFilterPopup()">
        <div onclick="event.stopPropagation()" id="popupContent"
             class="w-full bg-white rounded-t-2xl p-5 max-h-[60%] overflow-y-auto transform -translate-y transition-transform duration-300">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Filter Produk</h2>
                <button onclick="closeFilterPopup()" class="text-2xl text-gray-600">&times;</button>
            </div>

            <form method="GET" class="flex flex-col gap-4">

                <!-- Urutkan -->
                <div class="border rounded shadow p-4">
                    <label class="font-semibold">Urutkan Berdasarkan:</label>
                    <hr class="my-2">
                    <div class="flex flex-col gap-1">
                        @foreach(['populer', 'terlaris', 'terbaru'] as $sort)
                            <label class="inline-flex items-center">
                                <input type="radio" name="sort" value="{{ $sort }}"
                                       {{ request('sort') === $sort ? 'checked' : '' }}
                                       class="form-radio text-black">
                                <span class="ml-2 capitalize">{{ $sort }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Harga -->
                <div class="border rounded shadow p-4">
                    <label class="font-semibold">Harga (Rp)</label>
                    <hr class="my-1">
                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span id="minPriceDisplayMobile">Rp{{ number_format(request('price_min', 0), 0, ',', '.') }}</span>
                        <span id="maxPriceDisplayMobile">Rp{{ number_format(request('price_max', 10000000), 0, ',', '.') }}</span>
                    </div>
                    <input type="range" name="price_min" id="price_min_mobile"
                           min="0" max="10000000" step="100000"
                           value="{{ request('price_min', 0) }}"
                           oninput="updateSliderDisplayMobile()">
                    <input type="range" name="price_max" id="price_max_mobile"
                           min="0" max="10000000" step="100000"
                           value="{{ request('price_max', 10000000) }}"
                           oninput="updateSliderDisplayMobile()" class="mt-2">
                </div>

                <!-- Kategori -->
                <div class="border rounded shadow p-4">
                    <label class="font-semibold mb-2">Kategori Produk</label>
                    <hr class="my-2">
                    <div class="flex flex-col gap-2">
                        @foreach ($categoriesList as $cat)
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" value="{{ $cat }}"
                                       {{ request('categories') === $cat ? 'checked' : '' }}
                                       class="form-radio text-black">
                                <span class="ml-2">{{ $cat }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Terapkan -->
                <div>
                    <button type="submit"
                            class="w-full py-2 bg-black text-white rounded hover:bg-gray-800 transition">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/628982115403" target="_blank"
       class="fixed bottom-5 right-5 z-50">
        <img src="/image/whatsapp.svg" alt="Chat via WhatsApp" class="w-14 h-14 rounded shadow-lg hover:opacity-80 transition" />
    </a>
@endsection

@push('scripts')
    <script>
        function updateSliderDisplay() {
            const min = document.getElementById('price_min');
            const max = document.getElementById('price_max');
            if (min && max) {
                document.getElementById('minPriceDisplay').innerText = 'Rp' + Number(min.value).toLocaleString('id-ID');
                document.getElementById('maxPriceDisplay').innerText = 'Rp' + Number(max.value).toLocaleString('id-ID');
            }
        }

        function updateSliderDisplayMobile() {
            const min = document.getElementById('price_min_mobile');
            const max = document.getElementById('price_max_mobile');
            if (min && max) {
                document.getElementById('minPriceDisplayMobile').innerText = 'Rp' + Number(min.value).toLocaleString('id-ID');
                document.getElementById('maxPriceDisplayMobile').innerText = 'Rp' + Number(max.value).toLocaleString('id-ID');
            }
        }

        function openFilterPopup() {
            const popup = document.getElementById('filterPopup');
            const content = document.getElementById('popupContent');
            popup.classList.remove('hidden');
            setTimeout(() => content.classList.remove('translate-y-full'), 10);
        }

        function closeFilterPopup() {
            const popup = document.getElementById('filterPopup');
            const content = document.getElementById('popupContent');
            content.classList.add('translate-y-full');
            setTimeout(() => popup.classList.add('hidden'), 300);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateSliderDisplay();
            updateSliderDisplayMobile();
        });
    </script>
@endpush
