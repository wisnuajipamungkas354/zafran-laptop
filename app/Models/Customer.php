<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class);
    }
}
