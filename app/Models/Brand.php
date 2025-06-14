<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = ['id'];

    public function laptop() {
        return $this->hasMany(Laptop::class);
    }
}
