<?php

use App\Http\Middleware\RedirectIfNotCustomer;
use App\Livewire\LaptopCatalog;
use App\Livewire\LaptopDetail;
use App\Livewire\LoginCustomer;
use App\Livewire\RegisterCustomer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cobain');
});


Route::get('/login-customer', LoginCustomer::class)->name('login.customer');
Route::get('/register-customer', RegisterCustomer::class)->name('register.customer');
Route::get('/katalog', LaptopCatalog::class)->name('katalog');

Route::middleware(RedirectIfNotCustomer::class)->group(function () {
    Route::get('/katalog/detail/{id}', LaptopDetail::class)->name('katalog.detail');
});