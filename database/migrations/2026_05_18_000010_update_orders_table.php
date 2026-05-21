<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'preparing', 'shipping', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'address_id')) {
                $table->foreignId('address_id')->nullable()->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('orders', 'assigned_delivery_admin_id')) {
                $table->foreignId('assigned_delivery_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            }
            if (! Schema::hasColumn('orders', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'preparing_at')) {
                $table->timestamp('preparing_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'shipping_at')) {
                $table->timestamp('shipping_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'cancelled') NOT NULL DEFAULT 'pending'");
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('address_id');
            $table->dropConstrainedForeignId('assigned_delivery_admin_id');
            $table->dropColumn([
                'confirmed_at', 'preparing_at', 'shipping_at',
                'delivered_at', 'cancelled_at', 'cancellation_reason',
            ]);
        });
    }
};
