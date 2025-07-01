@extends('layouts.adminApp')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
        <span class="text-lg ml-8 lg:ml-0 font-bold">Daftar Produk</span>
        <a href="{{ route('products.create') }}"
           class="text-sm mt-2 px-4 py-2 rounded border">
            + Tambah Produk
        </a>
    </div>

    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari produk..."
               class="border rounded px-3 py-2 w-full sm:w-1/3">
    </div>

    <div class="overflow-x-auto rounded">
        <table class="min-w-[800px] w-full text-sm rounded-xl text-left shadow text-gray-700">
            <thead>
            <tr>
                <th>Gambar</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody class="border">
            @foreach ($products as $product)
                <tr class="border-t">
                    <td>
                        @if ($product->image)
                            <img src="data:image/jpeg;base64,{{ base64_encode($product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded" />
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->categories }}</td>
                    <td>{{ $product->SKU }}</td>
                    <td><strong>Rp.{{ $product->price }}</strong></td>
                    <td class="space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="px-3 py-1 hover:text-green-600">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class=" px-3 py-1 text-red rounded hover:text-red-600"
                                    onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {!! $products->links() !!}
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const nameCell = row.cells[1];
                if (!nameCell) return;

                const name = nameCell.textContent.toLowerCase();
                row.style.display = name.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
