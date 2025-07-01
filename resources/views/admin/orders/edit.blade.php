@extends('layouts.adminApp')

@section('content')
    <body class="bg-[#fef9f4] font-sans min-h-screen relative">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Ubah Status Pesanan</h2>
        Kode pesanan :
        <p class="text-lg font-semibold text-indigo-600">{{ $order->order_code }}</p>
        <br>

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2">
                    @foreach(['pending', 'paid', 'processing', 'shipped', 'delivered','success', 'cancelled', 'failed'] as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan
            </button>
        </form>
        <h2 class="text-lg font-semibold mt-6 mb-2">Informasi Pengiriman :</h2>
        <div class="space-y-1 text-sm border rounded-2xl">
            <div class="pl-3 pt-3 pb-3">
            <div class="pb-1"><strong>Nama :</strong> {{ $order->name }}</div>
            <div class="pb-1"><strong>Email :</strong> {{ $order->email }}</div>
            <div class="pb-1"><strong>Telepon :</strong> {{ $order->phone }}</div>
            <div class="pb-1"><strong>Alamat :</strong> {{ $order->alamat }}</div>
            <div class="pb-1"><strong>Kecamatan :</strong> {{ $order->kecamatan }}</div>
            <div class="pb-1"><strong>Kelurahan :</strong> {{ $order->kelurahan }}</div>
            <div class="pb-1"><strong>Kode Pos :</strong> {{ $order->kode_pos }}</div>
        </div>
        </div>
    </div>
    </body>
@endsection
