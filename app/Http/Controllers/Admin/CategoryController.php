<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SubCategory;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::with(['subCategories', 'products'])->get()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('categories')]
        ]);

        // Create category
        $category = Category::create(['name' => request('name')]);

        // Create subcategories if exists
        if (request('subcategories')) {
            foreach (explode(',', request('subcategories')) as $subCategory) {
                $category->subCategories()->create(['name' => $subCategory]);
            }
        }
        return back()->with('success', 'Category created successfully');
    }

    public function update(Category $category)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('categories')->ignore($category->id)],
            'subcategories' => ['sometimes', 'array'],
            'subcategories.*.name' => ['required'],
        ]);

        // Update category
        $category->update(['name' => request('name')]);

        // Check for removed subcategories and delete
        $hasError = false;
        $hasErrorCount = 0;
        foreach ($category->subCategories()->with(['products'])->get() as $selectedSubCategory) {
            $found = false;
            if (request('subcategories')) {
                foreach (request('subcategories') as $allowableSubCategory) {
                    if ($allowableSubCategory['id'] == $selectedSubCategory['id']) $found = true;
                }
            }
            if (!$found) {
                if (count($selectedSubCategory->products) == 0){
                     $selectedSubCategory->delete();
                }else{
                    $hasError = true;
                    $hasErrorCount++;
                }
            }
        }


        // Update or create subcategories
        if (request('subcategories')) {
            foreach (request('subcategories') as $subCategory) {
                if ($subCategory['id']){
                    $currentSubCategory = $category->subCategories()->where('id', $subCategory['id'])->first();
                    if ($currentSubCategory) $currentSubCategory->update(['name' => $subCategory['name']]);
                }else{
                    $category->subCategories()->create(['name' => $subCategory['name']]);
                }
            }
        }
        if ($hasError) $msg = 'Category updated successfully '.$hasErrorCount.' subcategories not deleted, associated products found';
        else $msg = 'Category updated successfully';
        return back()->with('success', $msg);
    }

    public function destroy(Category $category)
    {
        // Check if category has associated products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Can\'t delete category, associated products found');
        }
        // Delete category and associated subcategories
        $category->subCategories()->delete();
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }

    public function getSubcategoriesByIds()
    {
        $subCategories = SubCategory::whereIn('category_id', request()->ids)->get();
        return response()->json($subCategories, 200);
    }
}