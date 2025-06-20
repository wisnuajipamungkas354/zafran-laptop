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
        // Ambil tahun dan bulan saat ini
        $yearMonth = date('ym', mktime(24,0,0,date('m'),0,date('y'))); // Dua digit tahun & bulan (contoh: 2411)

        // Ambil ID unik yang belum dipakai untuk bulan dan tahun yang sama
        $getLastId = self::latest('id')->value('id');
        $prefixId = substr($getLastId, 0, 4);
        $uniqueId = 1;

        // Jika id terakhir sama dengan bulan dan tahun hari ini maka id terakhir + 1
        if($prefixId == $yearMonth) { 
            $lastIdNumber = (int)substr($getLastId, 4);
            $uniqueId= $lastIdNumber + 1;
        }

        // Format ID unik menjadi empat digit
        $uniqueIdFormatted = str_pad($uniqueId, 4, '0', STR_PAD_LEFT);

        // Gabungkan tahun, bulan, dan ID unik untuk membuat ID lengkap
        $finalId = $yearMonth . $uniqueIdFormatted;

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
