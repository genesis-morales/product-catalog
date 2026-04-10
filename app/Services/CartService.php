<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(Request $request): Cart
    {
        if ($request->user()) {
            return Cart::firstOrCreate([
                'user_id' => $request->user()->id,
                'status' => 'open',
            ]);
        }

        $guestToken = $this->resolveGuestToken($request);

        return Cart::firstOrCreate([
            'guest_token' => $guestToken,
            'status' => 'open',
        ], [
            'guest_token' => $guestToken,
        ]);
    }

    public function attachGuestCookie(Response $response, Cart $cart): Response
    {
        if (! $cart->user_id && $cart->guest_token && ! request()->cookie('cart_token')) {
            return $response->cookie('cart_token', $cart->guest_token, 60 * 24 * 30, '/', null, false, true);
        }

        return $response;
    }

    public function addItem(Cart $cart, Product $product, int $quantity): CartItem
    {
        $item = $cart->items()->firstOrNew([
            'product_id' => $product->id,
        ]);

        $item->quantity = max(1, $item->quantity + $quantity);
        $item->unit_price = $product->price;
        $item->save();

        return $item;
    }

    public function updateItem(CartItem $item, int $quantity): CartItem
    {
        $item->quantity = max(1, $quantity);
        $item->unit_price = $item->product->price;
        $item->save();

        return $item;
    }

    public function resolveGuestToken(Request $request): string
    {
        return $request->cookie('cart_token') ?? Str::uuid();
    }
}
