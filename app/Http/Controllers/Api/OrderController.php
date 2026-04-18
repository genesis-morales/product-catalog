<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->get();

        return OrderResource::collection($orders);
    }

    public function store(Request $request, CartService $cartService)
    {
        $data = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'shipping_city'    => 'required|string|max:100',
            'shipping_notes'   => 'nullable|string|max:500',
        ]);

        $cartService->mergeGuestCart($request, $request->user());

        $cart = $cartService->getCart($request)->load('items.product');

        abort_if($cart->items->isEmpty(), 422, 'El carrito está vacío');

        $order = Order::create([
            ...$data,
            'user_id'      => $request->user()->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal'     => $cart->subtotal,
            'total'        => $cart->total,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'unit_price'   => $item->unit_price,
                'quantity'     => $item->quantity,
                'total_price'  => $item->total_price,
            ]);
        }

        $cart->items()->delete();
        $cart->update(['status' => 'completed']);

        return response()->json(new OrderResource($order->load('items')), 201);
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);

        return new OrderResource($order->load('items'));
    }
}