<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['preparing', 'out_for_delivery', 'delivered', 'cancelled']);
            $table->text('note')->nullable();
            $table->timestamp('tracked_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_trackings');
    }
};
