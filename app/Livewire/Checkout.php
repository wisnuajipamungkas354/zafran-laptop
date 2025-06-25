<?php

namespace App\Livewire;

use App\Models\CustomerAddress;
use App\Models\Laptop;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public $buyNow = false;
    public $laptopId;
    public $quantity;
    public $cartItems = [];
    public $shipping_address;
    public $addresses = [];
    public $selected_address_id;
    public $showAddAddressModal = false;
    public $new_address = [
        'label' => '',
        'address' => '',
    ];
    public $total_amount = 0;

    public function mount()
    {
        if(!Auth::guard('customer')->check()) {
            return $this->redirect('/login-customer', navigate:true);
        }

        $this->buyNow = request()->has('buy_now');
        $this->laptopId = request()->get('laptop_id');
        $this->quantity = request()->get('quantity', 1);
    
        if ($this->buyNow && $this->laptopId) {
            $laptop = Laptop::findOrFail($this->laptopId);
            $this->cartItems = collect([
                (object)[
                    'laptop' => $laptop,
                    'laptop_id' => $laptop->id,
                    'quantity' => $this->quantity,
                ]
            ]);
        } else {
            $this->cartItems = ShoppingCart::with('laptop')
                ->where('customer_id', auth('customer')->id())
                ->get();

        }
            
        $this->total_amount = $this->cartItems->sum(fn($item) => $item->laptop->price * $item->quantity);
        $this->addresses = auth('customer')->user()->customerAddress()->get();
    }

    public function placeOrder()
    {
        if ($this->selected_address_id) {
            $this->shipping_address = CustomerAddress::find($this->selected_address_id)?->address;
        }
        
        $this->validate([
            'shipping_address' => 'required|string|min:10',
        ],[
            'shipping_address.required' => 'Masukkan alamat pengiriman',
            'shipping_address.min' => 'Masukkan alamat minimal 10 karakter',
        ]);

        DB::beginTransaction();

        try {
            
            $order = Order::create([
                'customer_id'     => auth('customer')->id(),
                'total_amount'    => $this->total_amount,
                'payment_status'  => 'pending',
                'order_status'    => 'pending',
                'shipping_address'=> $this->shipping_address,
            ]);

            foreach ($this->cartItems as $item) {
                if ($item->quantity > $item->laptop->stock) {
                    $this->addError('error', "Stok untuk {$item->laptop->model} tidak mencukupi.");
                    return;
                }

                OrderItem::create([
                    'order_id'       => $order->id,
                    'laptop_id'      => $item->laptop_id,
                    'quantity'       => $item->quantity,
                    'price_per_item' => $item->laptop->price,
                    'subtotal'      => $item->laptop->price * $item->quantity,
                ]);
            }

            // Hapus keranjang setelah berhasil checkout
            ShoppingCart::where('customer_id', auth('customer')->id())->delete();

            DB::commit();

            return redirect()->route('payment', ['order_number' => $order->order_number]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('error', 'Gagal memproses pesanan.' . $e->getMessage());
        }
    }

    public function saveNewAddress()
    {
        $this->validate([
            'new_address.label' => 'required|string|max:255',
            'new_address.address' => 'required|string',
        ]);

        $address = CustomerAddress::create([
            'customer_id' => auth('customer')->id(),
            'label' => $this->new_address['label'],
            'address' => $this->new_address['address'],
        ]);

        // Set sebagai alamat terpilih
        $this->selected_address_id = $address->id;
        $this->addresses = auth('customer')->user()->customerAddress()->get();
        $this->new_address = ['label' => '', 'address' => ''];
        $this->showAddAddressModal = false;
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
