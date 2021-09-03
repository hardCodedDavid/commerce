<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function newArrivals($category = null)
    {
        $products =  Product::where('is_listed', 1)
                            ->whereBetween('created_at', [now()->addDays(-30), now()])
                            ->with(['categories', 'media'])
                            ->latest();
        if ($category)
            $products = $products->whereHas('categories', function ($q) use ($category) { $q->where('name', $category); });
        $products = $products->paginate(24);
        return view('new-arrivals', compact('products', 'category'));
    }

    public function deals($category = null)
    {
        $products =  Product::where('is_listed', 1)
                            ->where('discount', '>', 0)
                            ->with(['categories', 'media'])
                            ->orderBy('discount');
        if ($category)
            $products = $products->whereHas('categories', function ($q) use ($category) { $q->where('name', $category); });
        $products = $products->paginate(24);
        return view('deals', compact('products', 'category'));
    }

    public function topSelling($category = null)
    {
        $products =  Product::where('is_listed', 1)
                            ->orderBy('sold', 'desc')
                            ->take(24);
        if ($category)
            $products = $products->whereHas('categories', function ($q) use ($category) { $q->where('name', $category); });
        $products = $products->get();
        return view('top-selling', compact('products', 'category'));
    }
}
