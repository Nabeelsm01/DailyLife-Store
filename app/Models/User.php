<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]; 
    }

    // ความสัมพันธ์กับ Shop
    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id');
    }

    // ตรวจสอบว่าเป็นผู้ขายหรือไม่
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    // ตรวจสอบว่าเป็น Admin หรือไม่
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // ตรวจสอบว่ามีร้านค้าหรือไม่
    public function hasShop()
    {
        return $this->shop()->exists();
    }
}
