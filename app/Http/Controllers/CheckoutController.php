<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:20',
            'alamat'    => 'required|string',
            'kecamatan'  => 'required|string|max:100',
            'kelurahan'  => 'required|string|max:100',
            'kode_pos'   => 'required|string|max:10',
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:cart_items,id',
        ]);


        $selectedItemIds = $request->input('selected_items');

        $cartItems = CartItem::whereIn('id', $selectedItemIds)
            ->where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Tidak ada item yang valid untuk checkout.');
        }

        return back()->with('success', 'Pesanan berhasil dibuat!');
    }

    public function destroy($id)
    {
        CartItem::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $total += $product->price * $item['quantity'];
            }

            //buat order
            $order = Order::create([
                'user_id'    => auth()->id(),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'total_price'=> $total,
                'status'     => 'pending',
                'name'       => $request->name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'alamat'     => $request->alamat,
                'kecamatan'  => $request->kecamatan,
                'kelurahan'  => $request->kelurahan,
                'kode_pos'   => $request->kode_pos,
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                // Tambah jumlah penjualan
                $product->increment('sales', $item['quantity']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $payload = [
                'transaction_details' => [
                    'order_id'     => $order->order_code,
                    'gross_amount' => (int)$order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'billing_address' => [
                        'alamat' => $request->alamat,
                        'city'    => $request->kecamatan . ' - ' . $request->kelurahan,
                        'postal_code' => $request->kode_pos,
                    ],
                ],
            ];

            $response = Snap::createTransaction($payload);

            $order->update([
                'snap_token' => $response->token,
                'payment_type' => 'bank_transfer',
            ]);

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'order_code' => $order->order_code,
                'midtrans' => $response,
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function history()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10); // Bisa kamu sesuaikan
        return view('admin.transaksi', compact('orders'));
    }
}
