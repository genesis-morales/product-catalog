<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(Request $request): Cart
    {
        if ($request->user()) {
            $this->mergeGuestCart($request, $request->user());

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

    public function attachGuestCookie(JsonResponse $response, Cart $cart): JsonResponse
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
        return $request->header('X-Cart-Token')
            ?? $request->cookie('cart_token')
            ?? (string) Str::uuid();
    }

    public function mergeGuestCart(Request $request, $user): void
    {
        $guestToken = $request->header('X-Cart-Token') ?? $request->cookie('cart_token');

        if (! $guestToken) {
            return;
        }

        $guestCart = Cart::with('items')
            ->where('guest_token', $guestToken)
            ->where('status', 'open')
            ->first();

        if (! $guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status'  => 'open',
        ]);

        if ($guestCart->id === $userCart->id) {
            return;
        }

        foreach ($guestCart->items as $item) {
            $existing = $userCart->items()->where('product_id', $item->product_id)->first();

            if ($existing) {
                $existing->quantity += $item->quantity;
                $existing->unit_price = $item->unit_price;
                $existing->save();
                $item->delete();
            } else {
                $item->cart_id = $userCart->id;
                $item->save();
            }
        }

        $guestCart->delete();
    }
}