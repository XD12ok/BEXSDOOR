<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('Midtrans callback received', $request->all()); // Log untuk debugging

        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Validasi signature
        $expectedSignature = hash('sha512',
            $request->order_id . $request->status_code . $request->gross_amount . $serverKey
        );

        if ($expectedSignature !== $request->signature_key) {
            return response(['message' => 'Invalid signature'], 403);
        }

        // Validasi input yang dibutuhkan
        $validated = $request->validate([
            'order_id' => 'required|string',
            'status_code' => 'required|string',
            'gross_amount' => 'required|numeric',
            'transaction_status' => 'required|string',
            'signature_key' => 'required|string',
        ]);

        // Validasi status yang diperbolehkan
        $validStatuses = ['settlement', 'capture', 'pending', 'expire', 'cancel', 'deny'];
        if (!in_array($request->transaction_status, $validStatuses)) {
            return response(['message' => 'Invalid transaction status'], 400);
        }

        // Temukan order berdasarkan order_code
        $order = Order::where('order_code', $request->order_id)->first();
        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }

        // Update status pesanan sesuai dengan status transaksi
        switch ($request->transaction_status) {
            case 'settlement':
            case 'capture':
                $order->status = 'paid';
                break;

            case 'pending':
                $order->status = 'pending';
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $order->status = 'failed';
                break;
        }

        $order->save();

        return response(['message' => 'Order updated successfully'], 200);
    }

}
