@extends('layouts.adminApp')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
        <span class="text-lg ml-8 lg:ml-0 font-bold">Daftar Pembayaran</span>
    </div>

    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari produk..."
               class="border rounded px-3 py-2 w-full sm:w-1/3">
    </div>

    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-[700px] w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-2">Order Code</th>
                <th class="px-4 py-2">Nama Customer</th>
                <th class="px-4 py-2">Metode</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Status</th>
            </tr>
            </thead>
            <tbody class="border-t">
            @foreach ($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $order->order_code }}</td>
                    <td class="px-4 py-2">{{ $order->name }}</td>
                    <td class="px-4 py-2">{{ ucfirst($order->payment_type) }}</td>
                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                {{ $order->status == 'paid' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

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
