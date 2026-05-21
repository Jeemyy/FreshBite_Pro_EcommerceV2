<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class InvoiceService
{
    public static function generateInvoice(Order $order): Invoice
    {
        $invoiceNumber = 'INV-'.now()->format('Ymd').'-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);

        return Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => now(),
            'total_amount' => $order->total_price,
            'status' => $order->payment?->status === 'paid' ? 'paid' : 'pending',
        ]);
    }

    public static function markAsPaid(Invoice $invoice): void
    {
        $invoice->update(['status' => 'paid']);
    }

    public static function markAsRefunded(Invoice $invoice): void
    {
        $invoice->update(['status' => 'refunded']);
    }

    public static function markAsCancelled(Invoice $invoice): void
    {
        $invoice->update(['status' => 'cancelled']);
    }
}
