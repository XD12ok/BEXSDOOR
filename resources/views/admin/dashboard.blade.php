@extends('layouts.adminApp')

@section('content')
    <div class="p-6 bg-[#fef9f4] min-h-screen">

        {{-- Stat Box --}}
        <div class="grid grid-cols-5 gap-4 mb-6">
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
                <label>Bulanan</label>
            </div>
            <div class="bg-gray-100 h-40 flex items-center justify-center text-gray-500 text-sm">
                    <canvas id="salesChart" height="100" width="800"></canvas>
            </div>
        </div>

        {{-- Penjualan Terakhir & Produk Populer --}}
        <div class="grid grid-cols-2 gap-6">
            {{-- Penjualan Terakhir --}}
            <div class="bg-white rounded-xl p-4 shadow">
                <h2 class="font-semibold text-black mb-4">Penjualan Terakhir</h2>
                <table class="w-full text-sm">
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
                <label>Produk populer</label>

                <ul class="text-sm mt-3">
                    @foreach ($produkPopuler as $produk)
                        <li class="flex justify-between mb-1">
                            <span>{{ $produk->name }}</span>
                            <span>{{ $produk->total_terjual }}x</span>
                        </li>
                    @endforeach
                </ul>
            </div>
    </div>

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
                backgroundColor: '#EEB657',
                borderRadius: 8,
                barThickness: 32,
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
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
