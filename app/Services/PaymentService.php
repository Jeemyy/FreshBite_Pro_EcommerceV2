<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public function processPayment(Order $order, string $method, array $gatewayData = []): Payment
    {
        return DB::transaction(function () use ($order, $method) {
            $payment = Payment::create([
                'user_id' => $order->user_id,
                'amount' => $order->total_price,
                'method' => $method,
                'status' => 'pending',
                'transaction_id' => Str::uuid()->toString(),
            ]);

            $order->update(['payment_id' => $payment->id]);

            $this->recordTransaction($payment, 'initiated', $order->total_price, [
                'gateway' => $method,
                'order_id' => $order->id,
            ]);

            return $payment;
        });
    }

    public function confirmPayment(Payment $payment, ?string $gatewayTransactionId = null): Payment
    {
        return DB::transaction(function () use ($payment, $gatewayTransactionId) {
            $payment->update([
                'status' => 'paid',
                'transaction_id' => $gatewayTransactionId ?? $payment->transaction_id,
            ]);

            $payment->orders()->each(function (Order $order) {
                $order->update([
                    'status' => 'confirmed',
                    'confirmed_at' => now(),
                ]);
            });

            $this->recordTransaction($payment, 'completed', $payment->amount, [
                'gateway_transaction_id' => $gatewayTransactionId,
            ]);

            InvoiceService::generateInvoice($payment->orders()->first());

            return $payment;
        });
    }

    public function failPayment(Payment $payment, ?string $reason = null): Payment
    {
        return DB::transaction(function () use ($payment, $reason) {
            $payment->update(['status' => 'failed']);

            $payment->orders()->each(function (Order $order) {
                $order->update(['status' => 'cancelled']);
            });

            $this->recordTransaction($payment, 'failed', $payment->amount, [
                'failure_reason' => $reason,
            ]);

            return $payment;
        });
    }

    public function refundPayment(Payment $payment): Payment
    {
        return DB::transaction(function () use ($payment) {
            $payment->update(['status' => 'refunded']);

            $payment->orders()->each(function (Order $order) {
                $order->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancellation_reason' => 'Payment refunded',
                ]);
            });

            $this->recordTransaction($payment, 'refunded', $payment->amount, [
                'refunded_at' => now()->toDateTimeString(),
            ]);

            return $payment;
        });
    }

    public function recordTransaction(Payment $payment, string $action, float $amount, ?array $gatewayResponse = null): TransactionHistory
    {
        return TransactionHistory::create([
            'payment_id' => $payment->id,
            'action' => $action,
            'amount' => $amount,
            'gateway_response' => $gatewayResponse,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
