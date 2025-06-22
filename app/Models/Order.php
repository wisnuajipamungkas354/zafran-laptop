<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public $incrementing = false;

    // Event "creating" untuk otomatis mengisi pengkodean id
    protected static function booted()
    {
        static::creating(function ($model) {
            // Panggil fungsi untuk generate id
            $model->id = self::generateUniqueId($model);
        });
    }

    public static function generateUniqueId($model)
    {
        $finalId = now()->timestamp;

        return $finalId;
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
