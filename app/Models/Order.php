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

        // Ambil order_number terakhir yang diawali tanggal hari ini
        $lastOrder = self::where('order_number', 'like', $prefix . '%')
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            // Ambil 4 digit terakhir sebagai nomor urut
            $lastNumber = (int)substr($lastOrder->order_number, -4);
        } else {
            $lastNumber = 0;
        }

        $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return $prefix . $nextNumber;
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
