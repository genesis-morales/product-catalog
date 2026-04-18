<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_orders'       => Order::count(),
            'total_revenue'      => (float) Order::where('status', '!=', 'cancelled')->sum('total'),
            'active_products'    => Product::where('available', true)->count(),
            'total_customers'    => User::where('role', 'customer')->count(),
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'processing_orders'  => Order::where('status', 'processing')->count(),
            'completed_orders'   => Order::where('status', 'completed')->count(),
            'cancelled_orders'   => Order::where('status', 'cancelled')->count(),
        ]);
    }

    public function monthlySales()
    {
        $data = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month_num'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('year', 'month_num')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get()
            ->map(fn($row) => [
                'month'  => Carbon::create($row->year, $row->month_num)->format('M Y'),
                'total'  => (float) $row->total,
                'orders' => (int) $row->orders,
            ]);

        return response()->json($data);
    }

    public function recentOrders()
    {
        $orders = Order::with('user:id,name,email')
            ->latest()
            ->take(8)
            ->get([
                'id', 'user_id', 'order_number',
                'shipping_name', 'status', 'total', 'created_at'
            ]);

        return response()->json($orders);
    }

    public function topProducts()
    {
        $products = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold, SUM(total_price) as revenue')
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'id'         => $item->product_id,
                'name'       => $item->product?->name ?? 'Producto eliminado',
                'total_sold' => (int) $item->total_sold,
                'revenue'    => (float) $item->revenue,
            ]);

        return response()->json($products);
    }
}