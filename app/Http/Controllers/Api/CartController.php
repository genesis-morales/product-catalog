<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(Request $request, CartService $cartService)
    {
        $cart = $cartService->getCart($request)->load(['items.product']);

        $response = response()->json(new CartResource($cart));

        return $cartService->attachGuestCookie($response, $cart);
    }

    public function addItem(StoreCartItemRequest $request, CartService $cartService)
    {
        $cart = $cartService->getCart($request);
        $product = Product::findOrFail($request->input('product_id'));

        $cartService->addItem($cart, $product, $request->input('quantity'));

        $response = response()->json(new CartResource($cart->fresh(['items.product'])), 201);

        return $cartService->attachGuestCookie($response, $cart);
    }

    public function updateItem(UpdateCartItemRequest $request, CartItem $item, CartService $cartService)
    {
        $cart = $cartService->getCart(request());

        abort_unless($item->cart_id === $cart->id, 403, 'El artículo no pertenece a este carrito.');

        $cartService->updateItem($item, $request->input('quantity'));

        return response()->json(new CartResource($cart->fresh(['items.product'])));
    }

    public function removeItem(CartItem $item, CartService $cartService)
    {
        $cart = $cartService->getCart(request());

        abort_unless($item->cart_id === $cart->id, 403, 'El artículo no pertenece a este carrito.');

        $item->delete();

        return response()->json(['message' => 'Item eliminado del carrito'], 200);
    }

    public function prepareCheckout(Request $request, CartService $cartService)
    {
        $cart = $cartService->getCart($request)->load(['items.product']);

        return response()->json([
            'message' => 'Carrito listo para checkout',
            'cart' => new CartResource($cart),
        ]);
    }
}
