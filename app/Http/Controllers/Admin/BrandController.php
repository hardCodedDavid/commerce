<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index', [
            'brands' => Brand::with(['products'])->get()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('brands')]
        ]);

        // Create brand
        Brand::create(request()->all());
        return back()->with('success', 'Brand created successfully');
    }

    public function update(Brand $brand)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('brands')->ignore($brand->id)]
        ]);

        // Update brand
        $brand->update(request()->all());
        return back()->with('success', 'Brand updated successfully');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return back()->with('error', 'Can\'t delete brand, associated products found');
        }

        // Delete brand
        $brand->delete();
        return back()->with('success', 'Brand deleted successfully');
    }
}
