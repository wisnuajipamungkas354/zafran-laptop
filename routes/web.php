<?php

use App\Livewire\LaptopCatalog;
use App\Livewire\LaptopDetail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cobain');
});

Route::get('/katalog', LaptopCatalog::class)->name('katalog');
Route::get('/katalog/detail/{id}', LaptopDetail::class)->name('katalog.detail');