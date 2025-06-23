<?php

namespace App\Livewire;

use App\Models\Laptop;
use App\Models\ShoppingCart;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class LaptopDetail extends Component
{
    public $laptop;
    public $quantity = 1;
    public $subtotal = 0;

    public function mount($id)
    {
        $this->laptop = Laptop::with('brand')->findOrFail($id);
        $this->calculateSubtotal();
    }

    public function updatedQuantity()
    {
        $this->calculateSubtotal();
    }

    public function calculateSubtotal()
    {
        $this->subtotal = $this->laptop->price * $this->quantity;
    }

    public function addToCart()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login.customer'); // jika belum login
        }

        ShoppingCart::updateOrCreate(
            [
                'customer_id' => Auth::guard('customer')->id(),
                'laptop_id' => $this->laptop->id,
                'quantity' => $this->quantity,
                'price_per_item' => $this->laptop->price,
                'sub_total' => $this->laptop->price * $this->quantity,
            ]
        );

       // Emit event untuk alert
       LivewireAlert::title('Berhasil')
            ->text('Laptop berhasil masuk keranjang.')
            ->success()
            ->show();
    }

    public function buyNow()
    {
        if(!Auth::guard('customer')->check()) {
            return $this->redirect('/login-customer', navigate:true);
        }

        if ($this->quantity > $this->laptop->stock) {
            $this->addError('quantity', 'Jumlah melebihi stok tersedia.');
            return;
        }

        return redirect()->route('checkout', [
            'buy_now' => 1,
            'laptop_id' => $this->laptop->id,
            'quantity' => $this->quantity,
        ]);
    }

    public function render()
    {
        return view('livewire.laptop-detail');
    }
}
