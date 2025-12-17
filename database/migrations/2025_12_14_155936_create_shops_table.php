<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // เจ้าของร้าน
            $table->string('shop_name'); // ชื่อร้าน
            $table->text('shop_description')->nullable(); // รายละเอียดร้าน
            $table->text('shop_address')->nullable(); // ที่อยู่
            $table->string('shop_phone')->nullable(); // เบอร์โทร
            $table->string('shop_logo')->nullable(); // โลโก้ร้าน
            $table->boolean('is_active')->default(true); // เปิด/ปิดร้าน
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
};