<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::whereIn('status', ['confirmed', 'preparing', 'shipping'])->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        $revenueChartData = Payment::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $pendingPayments = Payment::where('status', 'pending')->count();
        $failedPayments = Payment::where('status', 'failed')->count();

        return view('admin.index', compact(
            'totalRevenue', 'monthlyRevenue', 'totalOrders',
            'pendingOrders', 'processingOrders', 'deliveredOrders',
            'cancelledOrders', 'totalCustomers', 'totalProducts',
            'recentOrders', 'revenueChartData', 'ordersByStatus',
            'pendingPayments', 'failedPayments',
        ));
    }
}
