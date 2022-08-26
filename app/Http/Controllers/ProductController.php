<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Models\Product;

class ProductController extends Controller
{
    public function newArrivals($category = null)
    {
        SEOMeta::setTitle('New Arrivals');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('newArrivals'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('New Arrivals');
        OpenGraph::setUrl(route('newArrivals'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('New Arrivals');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

        $products =  Product::where('is_listed', 1)
                            ->whereBetween('created_at', [now()->subDays(30), now()])
                            ->with(['categories', 'media'])
                            ->latest();
        if ($category)
            $products = $products->whereHas('categories', function ($q) use ($category) { $q->where('name', $category); });
        $products = $products->paginate(24);
        return view('new-arrivals', compact('products', 'category'));
    }

    public function deals($category = null)
    {
        SEOMeta::setTitle('Deals');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('deals'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('Deals');
        OpenGraph::setUrl(route('deals'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('Deals');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

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
        SEOMeta::setTitle('Top Selling');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('topSelling'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('Top Selling');
        OpenGraph::setUrl(route('topSelling'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('Top Selling');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

        $products =  Product::where('is_listed', 1)
                            ->orderBy('sold', 'desc')
                            ->take(24);
        if ($category)
            $products = $products->whereHas('categories', function ($q) use ($category) { $q->where('name', $category); });
        $products = $products->get();
        return view('top-selling', compact('products', 'category'));
    }
}
