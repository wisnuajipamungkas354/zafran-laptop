<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    protected $guarded = ['id'];

    public function setPasswordAttribute($value)
    {
        // Jangan hash ulang jika sudah bcrypt
        if (Hash::needsRehash($value)) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class);
    }

    public function laptopReturn() {
        return $this->hasMany(LaptopReturn::class);
    }

    public function customerAddress() {
        return $this->hasMany(CustomerAddress::class);
    }
}
