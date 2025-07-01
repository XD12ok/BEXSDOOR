<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            // Ambil data notifikasi dari Midtrans
            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $grossAmount = $notification->gross_amount;
            $signatureKey = $request->signature_key;

            Log::info('Midtrans Callback', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);

            // Validasi signature
            $expectedSignature = hash('sha512', $orderId . $request->status_code . $grossAmount . Config::$serverKey);
            if ($signatureKey !== $expectedSignature) {
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            // Temukan pesanan
            $order = Order::where('order_code', $orderId)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Mapping status Midtrans ke status sistem
            $newStatus = match ($transactionStatus) {
                'settlement', 'capture' => 'paid',
                'pending' => 'pending',
                'cancel', 'expire', 'deny' => 'failed',
                default => $order->status, // tidak mengubah
            };

            $order->status = $newStatus;
            $order->payment_type = $paymentType;
            $order->save();

            return response()->json(['message' => 'Order updated to: ' . $newStatus], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Callback failed'], 500);
        }
    }
}
