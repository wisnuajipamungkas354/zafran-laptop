<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TransactionDetail extends Component
{
    public $order;

    public function mount($order_number)
    {
        $this->order = Order::with(['orderItem.laptop','delivery'])
            ->where('customer_id', auth('customer')->id())
            ->where('order_number', $order_number)
            ->firstOrFail();
            
    }

    public function payment() {

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id'     => auth('customer')->id(),
                'total_amount'    => $this->order->total_amount,
                'payment_status'  => 'pending',
                'order_status'    => 'pending',
                'shipping_address'=> $this->order->shipping_address,
            ]);

            OrderItem::where('order_id', '=', $this->order->id)->update([
                'order_id'       => $order->id,
            ]);

            Order::query()->where('id', '=', $this->order->id)->delete();

            // Hapus keranjang setelah berhasil checkout
            ShoppingCart::where('customer_id', auth('customer')->id())->delete();

            DB::commit();

            return redirect()->route('payment', ['order_number' => $order->order_number]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error', 'Gagal memproses pesanan.' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction-detail');
    }
}
