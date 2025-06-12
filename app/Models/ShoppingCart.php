<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $guarded = [];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function laptop() {
        return $this->belongsTo(Laptop::class, 'laptop_id');
    }
}

