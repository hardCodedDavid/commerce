<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function shop()
    {
        $products = Product::where('is_listed', 1);
        if (request('sort') == 'sale')
            $products = $products->orderBy('sold');
        if (request('sort') == 'price')
            $products = $products->orderBy('sell_price');
        if (request('sort') == 'name')
            $products = $products->orderBy('name');
        $products = $products->paginate(request('rpp') ?? 24);
        return view('shop', compact('products'));
    }

    public function filterShop()
    {
        $products = Product::where('is_listed', 1);
        $from = request('from');
        $to = request('to');
        $brands = request('brands');
        $variations = request('variations');
        if ($from && $to)
            $products->whereBetween('sell_price', [$from, $to]);
        if ($variations)
            $products->whereHas('variationItems', function ($q) use ($variations) {
                $q->whereIn('variation_items.id', $variations);
            });
        if ($brands)
            $products->whereHas('brands', function ($q) use ($brands) {
                $q->whereIn('brands.id', $brands);
            });
        $products = $products->paginate(24);
        return view('shop', compact('products'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function wishlist()
    {
        return view('wishlist');
    }

    public function productDetail(Product $product)
    {
        $categories = $product->categories()->get()->map(function($category){
            return $category['id'];
        });
        $related = Product::whereHas('categories', function($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        })->where('id', '!=', $product['id'])->get();
        return view('product-detail', compact('product', 'related'));
    }
}
