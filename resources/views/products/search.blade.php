@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Hasil Pencarian: "{{ $query }}"</h2>

        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Tidak ditemukan produk dengan nama tersebut.</p>
        @endif
    </div>
@endsection
