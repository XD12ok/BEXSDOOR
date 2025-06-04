@extends('layouts.app')

@section('content')

    <!-- Sidebar -->
    <nav id="sidebar" class="fixed top-0 left-0 bottom-0 w-44 bg-black py-4 transform -translate-x-full md:translate-x-0 md:static md:flex md:flex-col transition-transform duration-300 ease-in-out z-40">
        <button class="text-white font-semibold px-5 py-3 text-left border-l-4 border-yellow-400 bg-blue-800">Profil Saya</button>
        <a href="{{route('userdashboard')}}" class="text-white font-semibold px-5 py-3 text-left hover:bg-blue-500 w-full">Profil Saya</a>
        <a href="{{route('orders.history')}}" class="text-white font-semibold px-5 py-3 text-left border-l-4 hover:bg-blue-500 bg-blue-800 border-yellow-400 w-full">Pesanan Saya</a>
    </nav>

    <!-- Overlay sidebar (untuk mobile) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

        <!-- Hamburger button mobile -->
        <header class="bg-white p-4 shadow-md md:hidden flex items-center">
            <button id="hamburger-btn" aria-label="Toggle sidebar" class="text-gray-700 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="ml-4 text-xl font-semibold text-gray-900">Profil Saya</h1>
        </header>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md mt-6">
        <h1 class="text-2xl font-bold mb-6">Riwayat Pembelian</h1>

        @if($orders->isEmpty())
            <p class="text-gray-600">Belum ada transaksi yang dilakukan.</p>
        @else
            @foreach($orders as $order)
                <div class="border rounded-lg mb-6 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="text-sm text-gray-500">Kode Pesanan:</p>
                            <p class="text-lg font-semibold text-indigo-600">{{ $order->order_code }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm
                        {{ $order->status === 'paid' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                    </div>

                    <p class="text-sm text-gray-600">Tanggal: {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600 mb-2">Metode Pembayaran: {{ $order->payment_type }}</p>

                    <div class="mt-3">
                        <p class="text-sm font-semibold mb-2">Detail Produk:</p>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 border p-3 rounded-md">
                                    @if ($item->product->image)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->product->image) }}" alt="Gambar Produk" class="w-16 h-16 object-cover rounded-md">
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
        @endif
    </div>
@endsection
