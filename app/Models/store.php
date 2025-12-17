<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem; // ⭐ เพิ่มบรรทัดนี้

class store extends Model
{
    use HasFactory;

    protected $table = 'products'; // ⭐ เพิ่มบรรทัดนี้
    protected $primaryKey = 'id';  // ⭐ เพิ่มบรรทัดนี้

    protected $fillable = [
        'user_id',
        'shop_id',  // เพิ่มบรรทัดนี้
        'name_prd',
        'detail_prd',
        'price_prd',
        'stock_prd',
        'promotion_type',
        'promotion_value',
        'img_prd',
        'category_prd',
    ];

        // ความสัมพันธ์กับรีวิว
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // คำนวณเรตติ้งเฉลี่ย
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // นับจำนวนรีวิว
    public function reviewsCount()
    {
        return $this->reviews()->count();
    }

    // ⭐ นับจำนวนที่ขายไปแล้ว
    public function totalSold()
    {
        return OrderItem::where('product_id', $this->id)
                        ->whereHas('order', function($query) {
                            $query->whereIn('status', ['delivered', 'shipped', 'processing']);
                        })
                        ->sum('quantity');
    }

    // ⭐ ความสัมพันธ์กับ order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }


    // ความสัมพันธ์กับ Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    // ความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
