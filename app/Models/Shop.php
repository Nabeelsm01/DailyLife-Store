<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'shop_address',
        'shop_phone',
        'shop_logo',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // ความสัมพันธ์กับ User (เจ้าของร้าน)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์กับสินค้า
    public function products()
    {
        return $this->hasMany(store::class, 'shop_id');
    }
}