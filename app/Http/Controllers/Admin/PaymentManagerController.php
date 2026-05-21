<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class PaymentManagerController extends Controller
{
    use LogsAdminActivity;

    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index(Request $request)
    {
        $query = Payment::with(['user', 'orders']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(15);

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $successfulPayments = Payment::where('status', 'paid')->count();
        $failedPayments = Payment::where('status', 'failed')->count();

        return view('admin.payments.index', compact(
            'payments', 'totalRevenue', 'pendingPayments',
            'successfulPayments', 'failedPayments'
        ));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'orders.items.product', 'transactions']);

        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Payment $payment)
    {
        $this->paymentService->confirmPayment($payment);

        $this->logActivity('payment_approved', $payment, "Approved payment #{$payment->id}");

        return back()->with('success', 'Payment approved successfully.');
    }

    public function markFailed(Payment $payment)
    {
        $this->paymentService->failPayment($payment, 'Marked as failed by admin');

        $this->logActivity('payment_failed', $payment, "Marked payment #{$payment->id} as failed");

        return back()->with('success', 'Payment marked as failed.');
    }

    public function refund(Payment $payment)
    {
        $this->paymentService->refundPayment($payment);

        $this->logActivity('payment_refunded', $payment, "Refunded payment #{$payment->id}");

        return back()->with('success', 'Payment refunded successfully.');
    }
}
