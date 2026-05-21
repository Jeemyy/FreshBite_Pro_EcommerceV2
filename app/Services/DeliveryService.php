<?php

namespace App\Services;

use App\Models\DeliveryTracking;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DeliveryService
{
    public function assignDeliveryEmployee(Order $order, int $adminId): Order
    {
        $order->update([
            'assigned_delivery_admin_id' => $adminId,
            'status' => 'preparing',
            'preparing_at' => now(),
        ]);

        $this->trackDelivery($order, 'preparing', "Order assigned to delivery employee #{$adminId} for preparation");

        return $order;
    }

    public function updateDeliveryStatus(Order $order, string $status, ?string $note = null): DeliveryTracking
    {
        return DB::transaction(function () use ($order, $status, $note) {
            $statusTimestamps = [
                'preparing' => 'preparing_at',
                'out_for_delivery' => 'shipping_at',
                'delivered' => 'delivered_at',
                'cancelled' => 'cancelled_at',
            ];

            if (isset($statusTimestamps[$status])) {
                $order->update([
                    'status' => $status,
                    $statusTimestamps[$status] => now(),
                ]);
            }

            return $this->trackDelivery($order, $status, $note);
        });
    }

    private function trackDelivery(Order $order, string $status, ?string $note = null): DeliveryTracking
    {
        return DeliveryTracking::create([
            'order_id' => $order->id,
            'admin_id' => auth('admin')->id(),
            'status' => $status,
            'note' => $note,
            'tracked_at' => now(),
        ]);
    }
}
