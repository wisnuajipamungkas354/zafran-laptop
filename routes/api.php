<?php

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/midtrans/webhook', function (Request $request) {
    $payload = $request->all();
    Log::info('📩 Midtrans Webhook API:', $payload);

    // Ambil order_id asli
    $order = Order::with('orderItem.laptop')->where('order_number', '=', $payload['order_id'])->firstOrFail();
    if (! $order) return response()->json(['message' => 'Order not found'], 404);

    // Ambil status Midtrans
    $status = $payload['transaction_status'] ?? '';
    $transactionId = $payload['transaction_id'] ?? '';
    $paymentType = $payload['payment_type'] ?? '';

    if ($status === 'settlement') {
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        foreach ($order->orderItem as $item) {
            $item->laptop->decrement('stock', $item->quantity);
        }

        Transaction::create([
            'order_id' => $order->id,
            'payment_type' => $paymentType,
            'transaction_id' => $transactionId,
            'status' => 'paid',
            'total_amount' => $order->total_amount,
            'response' => json_encode($payload),
        ]);
    }

    return response()->json(['message' => 'Webhook processed']);
});
