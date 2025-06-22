<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopReturn extends Model
{
    protected $guarded = ['id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    
    public function items()
    {
        return $this->hasMany(LaptopReturnItem::class, 'laptop_return_id');
    }
}
