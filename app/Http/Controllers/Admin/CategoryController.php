<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getSubcategoriesByIds()
    {
        $subCategories = SubCategory::whereIn('category_id', request()->ids)->get();
        return response()->json($subCategories, 200);
    }
}