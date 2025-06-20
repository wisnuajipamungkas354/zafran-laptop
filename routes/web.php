<?php

use App\Http\Middleware\RedirectIfNotCustomer;
use App\Livewire\Checkout;
use App\Livewire\LaptopCatalog;
use App\Livewire\LaptopDetail;
use App\Livewire\LoginCustomer;
use App\Livewire\PaymentPage;
use App\Livewire\RegisterCustomer;
use App\Livewire\TransactionDetail;
use App\Livewire\TransactionHistory;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cobain');
});


Route::get('/login-customer', LoginCustomer::class)->name('login.customer');
Route::get('/register-customer', RegisterCustomer::class)->name('register.customer');
Route::get('/katalog', LaptopCatalog::class)->name('katalog');
Route::get('/katalog/detail/{id}', LaptopDetail::class)->name('katalog.detail');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/transaksi', TransactionHistory::class)->name('transaksi');
Route::get('/transaksi/{id}', TransactionDetail::class)->name('transaksi.detail');
Route::get('/payment/{order}', PaymentPage::class)->name('payment');
Route::get('/payment-success', function (Request $request) {
    $order = Order::findOrFail($request->order_id);

    if ($order->payment_status === 'paid') {
        return redirect()->route('katalog')->with('success', 'Pembayaran berhasil.');
    }

    // Simpan transaksi dan update order
    $order->update([
        'payment_status' => 'paid',
        'order_status' => 'processing',
    ]);

    // Kurangi stok
    foreach ($order->orderItem as $item) {
        $item->laptop->decrement('stock', $item->quantity);
    }

    Transaction::create([
        'order_id' => $order->id,
        'payment_type' => 'midtrans',
        'transaction_id' => 'ORDER-' . $order->id,
        'status' => 'paid',
        'total_amount' => $order->total_amount,
        'response' => 'manual-success',
    ]);

    return redirect()->route('katalog')->with('success', 'Pembayaran berhasil.');
});
Route::middleware(RedirectIfNotCustomer::class)->group(function () {
});
