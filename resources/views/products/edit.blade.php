@extends('layouts.adminApp')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl p-8">

            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Edit Produk</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Update --}}
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Produk:</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Harga:</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kategori:</label>
                    <select name="categories" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Nata Series" {{ $product->categories == 'Nata Series' ? 'selected' : '' }}>Nata Series</option>
                        <option value="Yaza Series" {{ $product->categories == 'Yaza Series' ? 'selected' : '' }}>Yaza Series</option>
                        <option value="Hogma Series" {{ $product->categories == 'Hogma Series' ? 'selected' : '' }}>Hogma Series</option>
                        <option value="PVC" {{ $product->categories == 'PVC' ? 'selected' : '' }}>PVC</option>
                        <option value="Glass" {{ $product->categories == 'Glass' ? 'selected' : '' }}>Glass</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi:</label>
                     <textarea name="description" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                         {{ old('description', $product->description) }}
                     </textarea>
                    
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Warna:</label>
                    <input type="text" name="color" value="{{ old('color', $product->color) }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">SKU:</label>
                    <input type="text" name="SKU" value="{{ old('SKU', $product->SKU) }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Gambar (opsional):</label>
                    <input type="file" name="image" accept="image/*" class="w-full">
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit"
                            class="flex-grow bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                        Perbarui Produk
                    </button>
            </form>

            {{-- Form Hapus --}}
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="flex-shrink-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>
        </div>

        </div>
    </div>
@endsection
