<?php

use App\Http\Middleware\RedirectIfNotCustomer;
use App\Livewire\Checkout;
use App\Livewire\LaptopCatalog;
use App\Livewire\LaptopDetail;
use App\Livewire\LoginCustomer;
use App\Livewire\RegisterCustomer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cobain');
});


Route::get('/login-customer', LoginCustomer::class)->name('login.customer')->middleware('guard');
Route::get('/register-customer', RegisterCustomer::class)->name('register.customer')->middleware('guard');
Route::get('/katalog', LaptopCatalog::class)->name('katalog');
Route::get('/katalog/detail/{id}', LaptopDetail::class)->name('katalog.detail');
Route::get('/checkout', Checkout::class)->name('checkout');

Route::middleware(RedirectIfNotCustomer::class)->group(function () {
    
});