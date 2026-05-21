<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Services\DeliveryService;
use App\Traits\LogsAdminActivity;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use LogsAdminActivity;

    public function __construct(
        protected DeliveryService $deliveryService
    ) {}

    public function index(Request $request)
    {
        $query = Order::with(['user', 'assignedDeliveryAdmin', 'latestDeliveryTracking'])
            ->whereIn('status', ['preparing', 'shipping']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('delivery_admin_id')) {
            $query->where('assigned_delivery_admin_id', $request->delivery_admin_id);
        }

        $orders = $query->latest()->paginate(15);
        $deliveryEmployees = Admin::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['delivery-manager', 'delivery-employee']);
        })->get();

        $preparing = Order::where('status', 'preparing')->count();
        $shipping = Order::where('status', 'shipping')->count();
        $delivered = Order::where('status', 'delivered')->count();

        return view('admin.deliveries.index', compact(
            'orders', 'deliveryEmployees', 'preparing', 'shipping', 'delivered'
        ));
    }

    public function assignOrder(Request $request, Order $order)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:admins,id',
        ]);

        $this->deliveryService->assignDeliveryEmployee($order, $validated['admin_id']);

        $this->logActivity(
            'delivery_assigned',
            $order,
            "Assigned delivery admin #{$validated['admin_id']} to Order #{$order->id}",
        );

        return back()->with('success', 'Delivery employee assigned successfully.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:preparing,out_for_delivery,delivered,cancelled',
            'note' => 'nullable|string|max:500',
        ]);

        $this->deliveryService->updateDeliveryStatus($order, $validated['status'], $validated['note']);

        $this->logActivity(
            'delivery_status_updated',
            $order,
            "Delivery status for Order #{$order->id} updated to {$validated['status']}",
            ['status' => $order->getOriginal('status')],
            ['status' => $validated['status']],
        );

        return back()->with('success', "Delivery status updated to {$validated['status']}.");
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'address', 'assignedDeliveryAdmin', 'deliveryTrackings.admin']);

        return view('admin.deliveries.show', compact('order'));
    }
}
