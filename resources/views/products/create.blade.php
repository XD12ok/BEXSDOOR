@extends('layouts.adminApp')

@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">tambah Produk</h2>

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

            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Produk</label>
                    <input type="text" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Harga</label>
                    <input type="number" step="0.01" name="price" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kategori</label>
                    <select name="categories" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Nata Series">Nata Series</option>
                        <option value="Yaza Series">Yaza Series</option>
                        <option value="Hogma Series">Hogma Series</option>
                        <option value="PVC">PVC</option>
                        <option value="Glass">Glass</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                    <textarea type="text" name="description" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Warna</label>
                    <input type="text" name="color" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">SKU</label>
                    <input type="text" name="SKU" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Gambar Produk</label>
                    <input type="file" name="image" accept="image/*" class="w-full">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection
