<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogoutCustomer extends Component
{
    public function logout()
    {
        Auth::guard('customer')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login.customer');
    }

    public function render()
    {
        return view('livewire.logout-customer');
    }
}
