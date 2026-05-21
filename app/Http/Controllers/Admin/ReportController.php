<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');

        $startDate = match ($period) {
            'weekly' => Carbon::now()->subWeek(),
            'monthly' => Carbon::now()->subMonth(),
            'yearly' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonth(),
        };

        $revenueData = Payment::where('status', 'paid')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $orderData = Order::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');
        $totalOrders = Order::count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', compact(
            'revenueData', 'orderData', 'totalRevenue', 'monthlyRevenue',
            'totalOrders', 'totalCustomers', 'totalProducts',
            'averageOrderValue', 'ordersByStatus', 'recentOrders', 'period',
        ));
    }
}
