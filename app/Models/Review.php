<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment'
    ];

    // ความสัมพันธ์กับสินค้า
    public function product()
    {
        return $this->belongsTo(store::class, 'product_id');
    }

    // ความสัมพันธ์กับผู้ใช้
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}