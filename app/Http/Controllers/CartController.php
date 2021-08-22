<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartController extends Controller
{
    public function getCart(): JsonResponse
    {
        if (auth()->user())
            return self::fetchDbCartAsJSON();
        else
            return self::fetchSessionCartAsJSON();
    }

    public function addToCart(Product $product): JsonResponse
    {
        $this->validate(request(), [
            'quantity' => 'sometimes|numeric|min:1'
        ]);

        $newQuantity = (int) request('quantity') ?? 1;
        if (auth()->user()) {
            // Get cart
            self::processAddToCartViaDB($product, $newQuantity);
            return self::fetchDbCartAsJSON();
        } else {
            // Get cart
            $cartItems = session('cartItems') ?? [];
            // Product in cart
            $inCart = false;
            $updatedCartItem = [];
            foreach ($cartItems as $item) {
                $quantity = $item['quantity'];
                if ($item['product_id'] == $product['id']) {
                    $inCart = true;
                    $quantity += $newQuantity;
                }
                $updatedCartItem[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                ];
            }
            // Product not in cart
            if (!$inCart) {
                $cartItems[] = [
                    'product_id' => $product['id'],
                    'quantity' => $newQuantity
                ];
                $updatedCartItem = $cartItems;
            }
            // Update session
            session(['cartItems' => $updatedCartItem]);
            return self::fetchSessionCartAsJSON();
        }
    }

    public function updateCartItem(Product $product): JsonResponse
    {
        $this->validate(request(), [
            'quantity' => 'required|numeric|min:1'
        ]);
        $newQuantity = request('quantity');
        if (auth()->user()) {
            $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
            $cartItems = $cart->items;
            foreach ($cartItems as $item)
                if ($item['product_id'] == $product['id']) $item->update(['quantity' => $newQuantity]);
            return self::fetchDbCartAsJSON();
        } else {
            $cartItems = session('cartItems') ?? [];
            $updatedCartItem = [];
            foreach ($cartItems as $item) {
                $quantity = $item['quantity'];
                if ($item['product_id'] == $product['id']) {
                    $quantity = $newQuantity;
                }
                $updatedCartItem[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                ];
            }
            // Update session
            session(['cartItems' => $updatedCartItem]);
            return self::fetchSessionCartAsJSON();
        }
    }

    public function removeFromCart(Product $product): JsonResponse
    {
        if (auth()->user()) {
            $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
            $cartItems = $cart->items;
            foreach ($cartItems as $item)
                if ($item['product_id'] == $product['id']) $item->delete();
            return self::fetchDbCartAsJSON();
        } else {
            $cartItems = session('cartItems') ?? [];

            // Remove product from cart
            $updatedCartItem = [];
            foreach ($cartItems as $item)
                if ($item['product_id'] != $product['id']) $updatedCartItem[] = $item;
            // Update session
            session(['cartItems' => $updatedCartItem]);
            return self::fetchSessionCartAsJSON();
        }
    }

    public function clearCart(): array
    {
        if (auth()->user()) {
            $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
            $cart->items()->delete();
            return self::fetchDbCartAsArray();
        }else {
            session(['cartItems' => null]);
            return self::fetchSessionCartAsArray();
        }
    }


    public static function clearUserCart()
    {
        if (auth()->user()) {
            $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
            $cart->items()->delete();
        }else {
            session(['cartItems' => null]);
        }
    }

    public static function fetchSessionCartAsJSON(): JsonResponse
    {
        return response()->json(self::fetchSessionCartAsArray());
    }

    public static function fetchSessionCartAsArray(): array
    {
        $cartItems = session('cartItems') ?? [];
        $total = 0;
        $items = [];
        $updatedCartItem = [];
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $updatedCartItem[] = $item;
                $total += $product->getDiscountedPrice() * $item['quantity'];
                $items[] = [
                    'product' => new ProductResource($product),
                    'quantity' => $item['quantity']
                ];
            }
        }

        session(['cartItems' => $updatedCartItem]);
        return [
            'items' => $items,
            'total' => $total
        ];
    }

    public static function fetchDbCartAsJSON()
    {
        return response()->json(self::fetchDbCartAsArray());
    }

    public static function fetchDbCartAsArray()
    {
        $cart = auth()->user()
                        ->cart()
                        ->with(['items', 'items.product'])
                        ->first();
        $cart->updateTotal();
        $items = [];
        foreach ($cart->items()->get() as $item) {
            if ($item->product) {
                $items[] = [
                    'product' => new ProductResource($item->product),
                    'quantity' => $item['quantity']
                ];
            }
        }
        return [
            'items' => $items,
            'total' => $cart['total']
        ];
    }

    public static function processAddToCartViaDB($product, $newQuantity)
    {
        $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
        $cartItems = $cart->items;
        // Product in cart
        $inCart = false;
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $product['id']) {
                $inCart = true;
                $item->update(['quantity' => $item['quantity'] + $newQuantity]);
            }
        }
        // Product not in cart
        if (!$inCart) {
            $cart->items()->create([
                'product_id' => $product['id'],
                'quantity' => $newQuantity
            ]);
        }
    }

    public static function getUserCartAsArray(): array
    {
        if (auth()->user())
            return self::fetchDbCartAsArray();
        else
            return self::fetchSessionCartAsArray();
    }

    public static function moveSessionCartToDatabase()
    {
        $cartItems = session('cartItems') ?? [];
        foreach ($cartItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                self::processAddToCartViaDB($product, $item['quantity']);
            }
        }
        session(['cartItems' => null]);
    }

    public static function moveDatabaseCartToSession(): array
    {
        $cart = auth()->user()->cart()->with(['items', 'items.product'])->first();
        $items = [];
        foreach ($cart->items as $item) {
            $items[] = [
                'product_id' => $item->product['id'],
                'quantity' => $item['quantity']
            ];
        }
        return $items;
    }
}
