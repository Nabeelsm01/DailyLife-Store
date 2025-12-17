<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'selected'];

    protected $casts = [
        'selected' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(store::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}