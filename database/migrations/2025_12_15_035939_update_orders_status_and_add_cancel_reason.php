<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) เพิ่มค่า enum cancel_requested
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancel_requested',
                'cancelled'
            ) NOT NULL
        ");

        // 2) เพิ่มเหตุผลการยกเลิก (nullable)
        Schema::table('orders', function (Blueprint $table) {
            $table->text('cancel_reason')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        // ลบ column เหตุผล
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('cancel_reason');
        });

        // เอา cancel_requested ออกจาก enum
        DB::statement("
            ALTER TABLE orders
            MODIFY status ENUM(
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ) NOT NULL
        ");
    }
};
