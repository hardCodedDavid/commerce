<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getProducts(Category $category, $subcategory = null)
    {
        $products = $category->products()->where('is_listed', 1)->with('media');
        if ($subcategory)
            $products = $products->whereHas('subCategories', function($q) use ($subcategory) {
                $q->where('name', $subcategory);
            });
        $count = $products->count();
        if (request('sort') == 'sale')
            $products = $products->orderBy('sold');
        if (request('sort') == 'price')
            $products = $products->orderBy('sell_price');
        if (request('sort') == 'name')
            $products = $products->orderBy('name');
        $products = $products->paginate(request('rpp') ?? 24);
        return view('shop-categories', compact('category', 'products', 'count', 'subcategory'));
    }
}
