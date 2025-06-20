<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginCustomer extends Component
{
    public $email, $password;

    public function login()
    {
        if (Auth::guard('customer')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            return redirect()->route('katalog');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.login-customer');
    }
}
