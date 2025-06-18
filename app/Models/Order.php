<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderItem() {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction() {
        return $this->hasMany(Transaction::class);
    }
}
