<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Services\DeliveryService;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use LogsAdminActivity;

    public function __construct(
        protected DeliveryService $deliveryService
    ) {}

    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment', 'items.product', 'assignedDeliveryAdmin']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('id', $search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        $statuses = ['pending', 'confirmed', 'preparing', 'shipping', 'delivered', 'cancelled'];
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::whereIn('status', ['confirmed', 'preparing', 'shipping'])->count();
        $completedOrders = Order::where('status', 'delivered')->count();

        return view('admin.orders.index', compact(
            'orders', 'statuses', 'totalOrders', 'pendingOrders',
            'processingOrders', 'completedOrders'
        ));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment.transactions', 'address', 'assignedDeliveryAdmin', 'deliveryTrackings.admin', 'invoice']);

        $deliveryEmployees = Admin::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['delivery-manager', 'delivery-employee']);
        })->get();

        return view('admin.orders.show', compact('order', 'deliveryEmployees'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,preparing,shipping,delivered,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $order->update([
            'status' => $validated['status'],
            $validated['status'].'_at' => now(),
            'cancellation_reason' => $validated['cancellation_reason'] ?? null,
        ]);

        if (in_array($validated['status'], ['preparing', 'out_for_delivery', 'delivered', 'cancelled'])) {
            $this->deliveryService->updateDeliveryStatus($order, $validated['status'], $validated['cancellation_reason'] ?? 'Status updated by admin');
        }

        $this->logActivity(
            'order_status_updated',
            $order,
            "Order #{$order->id} status changed from {$oldStatus} to {$validated['status']}",
            ['status' => $oldStatus],
            ['status' => $validated['status']],
        );

        return back()->with('success', "Order status updated to {$validated['status']}.");
    }

    public function assignDelivery(Request $request, Order $order)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
        ]);

        $this->deliveryService->assignDeliveryEmployee($order, $validated['admin_id']);

        $this->logActivity(
            'order_assigned_delivery',
            $order,
            "Assigned delivery employee #{$validated['admin_id']} to Order #{$order->id}",
        );

        return back()->with('success', 'Delivery employee assigned successfully.');
    }

    public function destroy(Order $order)
    {
        $this->logActivity('order_deleted', $order, "Deleted Order #{$order->id}");
        $order->delete();

        return to_route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
