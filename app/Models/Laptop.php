<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $guarded = ['id'];

    public function orderItem() {
        return $this->hasMany(orderItem::class);
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class);
    }
}
