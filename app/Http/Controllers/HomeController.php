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
        return view('product-detail', compact('product'));
    }
}
