<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    public function getWishList(): JsonResponse
    {
        if (auth()->user())
            return self::fetchDbWishlistAsJSON();
        else
            return self::fetchSessionWishlistAsJSON();
    }

    public function wishListProduct(Product $product): JsonResponse
    {
        if (auth()->user()) {
            // Get wishlist
            $wishlist = auth()->user()->wishlistItems()->where('product_id', $product['id'])->first();
            if (!$wishlist)
                auth()->user()->wishlistItems()->create([
                    'product_id' => $product['id']
                ]);
            return self::fetchDbWishlistAsJSON();
        } else {
            // Get wishlist
            $wishlistItems = session('wishlistItems') ?? [];
            // Product in wishlist
            $inList = false;
            $updatedwishlistItems = [];
            foreach ($wishlistItems as $item) {
                $updatedwishlistItems[] = $item;
                if ($item['product_id'] == $product['id']) $inList = true;
            }
            // Product not in wishlist
            if (!$inList) {
                $updatedwishlistItems[] = [
                    'product_id' => $product['id']
                ];
            }
            // Update session
            session(['wishlistItems' => $updatedwishlistItems]);
            return self::fetchSessionWishlistAsJSON();
        }
    }

    public function removeFromWishlist(Product $product): JsonResponse
    {
        if (auth()->user()) {
            auth()->user()->wishlistItems()->where('product_id', $product['id'])->delete();
            return self::fetchDbWishlistAsJSON();
        } else {
            $wishlistItems = session('wishlistItems') ?? [];
            // Remove product from wishlist
            $updatedwishlistItems = [];
            foreach ($wishlistItems as $item)
                if ($item['product_id'] != $product['id']) $updatedwishlistItems[] = $item;
            // Update session
            session(['wishlistItems' => $updatedwishlistItems]);
            return self::fetchSessionWishlistAsJSON();
        }
    }

    public static function fetchSessionWishlistAsJSON(): JsonResponse
    {
        return response()->json(self::fetchSessionWishlistAsArray());
    }

    public static function fetchSessionWishlistAsArray(): array
    {
        $wishlistItems = session('wishlistItems') ?? [];
        $items = [];
        $updatedwishlistItems = [];
        foreach ($wishlistItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $updatedwishlistItems[] = $item;
                $items[] = new ProductResource($product);
            }
        }

        session(['wishlistItems' => $updatedwishlistItems]);
        return $items;
    }

    public static function fetchDbWishlistAsJSON(): JsonResponse
    {
        return response()->json(self::fetchDbWishlistAsArray());
    }

    public static function fetchDbWishlistAsArray(): array
    {
        $items = [];
        foreach (auth()->user()->wishlistItems()->with('product')->get() as $item) {
            if ($item->product) {
                $items[] = new ProductResource($item->product);
            }
        }
        return $items;
    }

    public static function moveSessionWishlistToDatabase()
    {
        $wishlistItems = session('wishlistItems') ?? [];
        foreach ($wishlistItems as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $wishlist = auth()->user()->wishlistItems()->where('product_id', $product['id'])->first();
                if (!$wishlist)
                    auth()->user()->wishlistItems()->create([
                        'product_id' => $product['id']
                    ]);
            }
        }
        session(['wishlistItems' => null]);
    }

    public static function moveDatabaseWishlistToSession(): array
    {
        $items = [];
        foreach (auth()->user()->wishlistItems()->with('product')->get() as $item) {
            $items[] = [
                'product_id' => $item->product['id']
            ];
        }
        return $items;
    }
}
