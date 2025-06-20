<?php

namespace App\Livewire;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterCustomer extends Component
{
    public $first_name, $last_name, $email, $password, $password_confirmation;

    public function register()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:customers,email',
            'password'   => 'required|min:6|same:password_confirmation',
        ]);

        $customer = Customer::create([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'password'   => Hash::make($this->password),
        ]);

        auth('customer')->login($customer);

        return redirect()->route('katalog');
    }

    public function render()
    {
        return view('livewire.register-customer');
    }
}
