<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaptopReturnItem extends Model
{
    protected $guarded = ['id'];

    public function laptopReturn()
    {
        return $this->belongsTo(LaptopReturn::class);
    }
}
