<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])
            ->latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhere('shipping_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $query->paginate($request->per_page ?? 10);
    }

    public function show(Order $order)
    {
        return $order->load(['user', 'items']);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return $order->fresh();
    }

    public function updateShipping(Request $request, Order $order)
    {
    $data = $request->validate([
        'shipping_name'    => 'required|string|max:255',
        'shipping_phone'   => 'required|string|max:20',
        'shipping_address' => 'required|string|max:255',
        'shipping_city'    => 'required|string|max:100',
        'shipping_notes'   => 'nullable|string|max:500',
    ]);

    $order->update($data);
    return $order->fresh();
    }
}