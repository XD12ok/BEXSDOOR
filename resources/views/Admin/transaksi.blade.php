@extends('layouts.adminApp')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <span class="text-lg font-bold">Daftar Pembayaran</span>
    </div>
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari produk..."
               class="border rounded px-3 py-2 w-1/3">
    </div>
    <table class="w-full text-sm text-left text-gray-700 shadow">
        <thead>
        <tr>
            <th>Order Code</th>
            <th>Nama Customer</th>
            <th>Metode</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody class="border">
        @foreach ($orders as $order)
            <tr class="border-t">
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ ucfirst($order->payment_type) }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <span class="inline-block px-2 py-1 rounded
                        {{ $order->status == 'paid' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {!! $orders->links() !!}
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const orderCodeCell = row.cells[0];
                if (!orderCodeCell) return;

                const orderCode = orderCodeCell.textContent.toLowerCase();
                row.style.display = orderCode.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endsection
