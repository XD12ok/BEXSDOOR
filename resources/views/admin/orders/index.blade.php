@extends('layouts.adminApp')

@section('content')
    <body class="bg-[#fef9f4] font-sans min-h-screen relative">
    <div class="max-w-7xl mx-auto mt-8">
        <h1 class="text-2xl mb-6">Daftar Semua Pesanan</h1>
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari produk..."
                   class="border rounded px-3 py-2 w-1/3">
        </div>

        @if($orders->isEmpty())
            <p class="text-gray-600">Belum ada pesanan.</p>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="order-item border rounded-lg shadow p-5 bg-white">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="text-sm text-gray-500">Kode Pesanan:</p>
                                <p class="text-lg font-semibold text-indigo-600 order-code">{{ $order->order_code }}</p>
                                <p class="text-sm text-gray-500">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                                <p class="text-sm text-gray-500">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Pelanggan: {{ $order->user->name ?? 'Guest' }} ({{ $order->user->email ?? '-' }})</p>
                            </div>

                            <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-sm
                                @switch($order->status)
                                    @case('paid') bg-green-100 text-green-600 @break
                                    @case('processing') bg-blue-100 text-blue-600 @break
                                    @case('shipped') bg-yellow-100 text-yellow-600 @break
                                    @case('completed') bg-gray-100 text-gray-800 @break
                                    @case('canceled') bg-red-100 text-red-600 @break
                                    @default bg-gray-100 text-gray-600
                                @endswitch">
                                {{ ucfirst($order->status) }}
                            </span>
                                <div class="mt-2">
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-sm text-blue-600 hover:underline">
                                        detail pemesanan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h3 class="font-medium mb-2">Produk Dipesan:</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-4 border p-3 rounded-md bg-gray-50">
                                        @if ($item->product->image)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($item->product->image) }}"
                                                 alt="Produk" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-sm text-gray-500">
                                                Tidak ada gambar
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                                            <p class="text-sm text-gray-500">Harga: Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const orders = document.querySelectorAll('.order-item');

            orders.forEach(order => {
                const codeElement = order.querySelector('.order-code');
                if (!codeElement) return;

                const orderCode = codeElement.textContent.toLowerCase();
                const match = orderCode.includes(keyword);

                order.style.display = match ? '' : 'none';
            });
        });
    </script>

@endsection
