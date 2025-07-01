@extends('layouts.adminApp')

@section('content')
    <div class="p-6 bg-[#fef9f4] min-h-screen">
        <span class="text-lg font-bold ml-3">DashBoard Penjualan</span>

        {{-- Stat Box --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 mt-4">
            <div class="bg-white rounded-xl p-4 shadow">
                <div class="text-sm text-gray-600">Total Penjualan</div>
                <div class="text-2xl font-bold text-black">{{ $totalPenjualan }}</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow">
                <div class="text-sm text-gray-600">Jumlah Transaksi</div>
                <div class="text-2xl font-bold text-black">{{ $jumlahTransaksi }}</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow">
                <div class="text-sm text-gray-600">Pendapatan bulan ini</div>
                <div class="text-2xl font-bold text-black">Rp{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow">
                <div class="text-sm text-gray-600">Pendapatan tahun ini</div>
                <div class="text-2xl font-bold text-black">Rp{{ number_format($pendapatanTahunIni, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- Grafik Ringkasan --}}
        <div class="bg-white rounded-xl p-4 shadow mb-6">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-semibold text-black">Ringkasan Penjualan</h2>
                <label class="text-sm text-gray-500">Bulanan</label>
            </div>
            <div class="overflow-x-auto">
                <div class="min-w-[600px]">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>

        {{-- Penjualan Terakhir & Produk Populer --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Penjualan Terakhir --}}
            <div class="bg-white rounded-xl p-4 shadow overflow-x-auto">
                <h2 class="font-semibold text-black mb-4">Penjualan Terakhir</h2>
                <table class="w-full text-sm min-w-[500px]">
                    <thead>
                    <tr class="text-left text-gray-600 border-b">
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Produk</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($penjualanTerakhir as $item)
                        <tr class="border-b text-black">
                            <td>{{ $item->order->name ?? 'Unknown' }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '--' }}</td>
                            <td class="text-orange-500">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            <td>{{ $item->product->name ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Produk Populer --}}
            <div class="bg-white rounded-xl p-4 shadow">
                <h2 class="font-semibold text-black mb-4">Produk Populer</h2>
                <ul class="text-sm space-y-1">
                    @foreach ($produkPopuler as $produk)
                        <li class="flex justify-between">
                            <span>{{ $produk->name }}</span>
                            <span>{{ $produk->total_terjual }}x</span>
                        </li>
                        <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const labels = [
            @foreach(range(1, 12) as $bulan)
                "{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->monthName }}",
            @endforeach
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: [
                    @foreach(range(1, 12) as $bulan)
                        {{ $penjualanPerBulan[$bulan] ?? 0 }},
                    @endforeach
                ],
                borderColor: '#EEB657',
                backgroundColor: '#FFFFFF',
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#EEB657',
                pointBorderWidth: 3,
                fill: false
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
