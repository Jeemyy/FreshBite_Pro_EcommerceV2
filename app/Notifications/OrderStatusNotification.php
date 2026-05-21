<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'shipping' => 'Shipping',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        $fromStatus = $statusLabels[$this->oldStatus] ?? $this->oldStatus;
        $toStatus = $statusLabels[$this->newStatus] ?? $this->newStatus;

        return (new MailMessage)
            ->subject("Order #{$this->order->id} Status Updated")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your order #{$this->order->id} status has been updated.")
            ->line("From: **{$fromStatus}**")
            ->line("To: **{$toStatus}**")
            ->line('Total: $'.number_format($this->order->total_price, 2))
            ->action('View Order', url('/orders/'.$this->order->id))
            ->line('Thank you for your business!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'total_price' => $this->order->total_price,
        ];
    }
}
