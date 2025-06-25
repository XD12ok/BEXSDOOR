@extends('layouts.app')

@section('content')
    <!-- Layout utama -->
    <div class="flex min-h-screen overflow-x-hidden">
            <!-- Konten Riwayat Pembelian -->
            <div class="w-full px-4 sm:px-6 lg:px-8 py-6 bg-white rounded-xl shadow-md mt-6">
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
        </div>
    </div>
@endsection
