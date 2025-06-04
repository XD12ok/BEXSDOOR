<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use carbon\carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function dashboard()
    {
        // Total penjualan (jumlah produk terjual)
        $totalPenjualan = OrderItem::sum('quantity');

        // Jumlah transaksi
        $jumlahTransaksi = Order::count();

        // Penjualan terakhir (ambil 5 terakhir)
        $penjualanTerakhir = OrderItem::with(['order', 'product'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Produk populer (berdasarkan jumlah produk terjual)
        $produkPopuler = Product::select('name', DB::raw('SUM(order_items.quantity) as total_terjual'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        $penjualanPerBulan = Order::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->pluck('jumlah', 'bulan');

        $pendapatanBulanIni = OrderItem::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;

        // Total pendapatan tahun ini
        $pendapatanTahunIni = OrderItem::whereYear('created_at', Carbon::now()->year)
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;

        return view('admin.dashboard', compact(
            'totalPenjualan',
            'jumlahTransaksi',
            'penjualanTerakhir',
            'produkPopuler',
            'penjualanPerBulan',
            'pendapatanBulanIni',
            'pendapatanTahunIni'
        ));
    }
}
