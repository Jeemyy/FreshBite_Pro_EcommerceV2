<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('card', 'cash', 'stripe', 'paypal') NOT NULL DEFAULT 'cash'");
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('panding', 'success', 'failed') NOT NULL DEFAULT 'panding'");
            DB::statement("ALTER TABLE payments MODIFY COLUMN method ENUM('card', 'cash') NOT NULL DEFAULT 'cash'");
        }
    }
};
