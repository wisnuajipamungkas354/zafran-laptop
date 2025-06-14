<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'laptop_images' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function orderItem() {
        return $this->hasMany(orderItem::class);
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class);
    }
}
