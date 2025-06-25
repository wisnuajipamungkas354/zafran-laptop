<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = self::generateNumericOrderId();
            }
        });
    }

    public static function generateNumericOrderId(): string
    {
        $datePart = now()->format('ymd'); // contoh: 250625
        $prefix = $datePart;

        $counter = 1;
        do {
            $sequence = str_pad($counter, 4, '0', STR_PAD_LEFT); // 0001, 0002, ...
            $orderNumber = $prefix . $sequence;

            $exists = self::where('order_number', $orderNumber)->exists();
            $counter++;
        } while ($exists && $counter <= 9999);

        return $orderNumber;
    }

    public function getRouteKeyName()
    {
        return 'order_number';
    }


    public function isReturnable()
    {
        if (!$this->delivery || !$this->delivery->delivery_date) return false;

        $daysSinceDelivery = now()->diffInDays($this->delivery->delivery_date);
        return $daysSinceDelivery <= 14;
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function orderItem() {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction() {
        return $this->hasMany(Transaction::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
