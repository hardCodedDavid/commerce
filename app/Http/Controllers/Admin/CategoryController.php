<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryBanner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SubCategory;
use App\Models\Category;
use Intervention\Image\Facades\Image;

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
            'name' => ['required', Rule::unique('categories')],
            'banners' => ['required', 'array'],
            'banners.*' => ['image', 'max:1024']
        ]);

        foreach (request('banners') as $banner) {
            $width = Image::make($banner)->width();
            $height = Image::make($banner)->height();
            if (($width < 390 || $width > 395) || ($height < 335 || $height > 340))
                return back()->with('error', 'All category banners must be of height (335 to 340)px and width (390 to 395)px')->withErrors(['banners' => 'All category banners must be of height (335 to 340)px and width (390 to 395)px'])->withInput();
        }

        // Create category
        $category = Category::create(['name' => request('name')]);

        // Create subcategories if exists
        if (request('subcategories')) {
            foreach (explode(',', request('subcategories')) as $subCategory) {
                $category->subCategories()->create(['name' => $subCategory]);
            }
        }

        foreach (request('banners') as $banner) {
            $destination = 'banners';
            $transferFile = 'BN'.time().mt_rand(100, 999).'.'.$banner->getClientOriginalExtension();
            $location = $banner->move($destination, $transferFile);
            $category->banners()->create(['url' => $location]);
        }
        return back()->with('success', 'Category created successfully');
    }

    public function update(Category $category)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('categories')->ignore($category->id)],
            'subcategories' => ['sometimes', 'array'],
            'subcategories.*.name' => ['required']
        ]);

        if ($banners = request('banners'))
            foreach ($banners as $banner) {
                $width = Image::make($banner)->width();
                $height = Image::make($banner)->height();
                if (($width < 390 || $width > 395) || ($height < 335 || $height > 340))
                    return back()->with('error', 'All category banners must be of height (335 to 340)px and width (390 to 395)px');
            }

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

        if ($banners = request('banners'))
            foreach ($banners as $banner) {
                $destination = 'banners';
                $transferFile = 'BN'.time().mt_rand(100, 999).'.'.$banner->getClientOriginalExtension();
                $location = $banner->move($destination, $transferFile);
                $category->banners()->create(['url' => $location]);
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

    public function destroyBanner(CategoryBanner $categoryBanner)
    {
        // Remove old file
        if (!$categoryBanner['url'])
            return response()->json(['success' => false], 404);

        $url = $categoryBanner['url'];
        if ($categoryBanner->delete()) {
            unlink($url);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function getSubcategoriesByIds()
    {
        $subCategories = SubCategory::whereIn('category_id', request()->ids)->get();
        return response()->json($subCategories, 200);
    }
}
