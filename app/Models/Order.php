<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'preparing_at' => 'datetime',
            'shipping_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function assignedDeliveryAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_delivery_admin_id');
    }

    public function deliveryTrackings(): HasMany
    {
        return $this->hasMany(DeliveryTracking::class);
    }

    public function latestDeliveryTracking(): HasOne
    {
        return $this->hasOne(DeliveryTracking::class)->latestOfMany();
    }
}
