<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminCustomerController extends Controller
{
    public function index(): JsonResponse
    {
        $customers = User::query()
            ->where('role', 'customer')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status != "cancelled" THEN orders.total ELSE 0 END), 0) as total_spent'),
                DB::raw('MAX(orders.created_at) as last_order_at')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('last_order_at')
            ->get()
            ->map(fn ($customer) => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'total_orders' => (int) $customer->total_orders,
                'total_spent' => (float) $customer->total_spent,
                'last_order_at' => $customer->last_order_at,
            ]);

        return response()->json($customers);
    }

    public function show(User $user): JsonResponse
    {
        abort_unless($user->role === 'customer', 404);

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get(['id', 'order_number', 'status', 'total', 'created_at']);

        $recentStatus = [
            'pending' => (int) $orders->where('status', 'pending')->count(),
            'processing' => (int) $orders->where('status', 'processing')->count(),
            'completed' => (int) $orders->where('status', 'completed')->count(),
            'cancelled' => (int) $orders->where('status', 'cancelled')->count(),
        ];

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'total_orders' => $orders->count(),
            'total_spent' => (float) $orders->where('status', '!=', 'cancelled')->sum('total'),
            'last_order_at' => optional($orders->first())->created_at,
            'recent_status' => $recentStatus,
            'orders' => $orders->map(fn ($order) => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => (float) $order->total,
                'created_at' => $order->created_at,
            ])->values(),
        ]);
    }
}