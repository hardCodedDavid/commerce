<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Variation;

class VariationController extends Controller
{
    public function index()
    {
        return view('admin.variations.index', [
            'variations' => Variation::with(['items', 'items.products'])->get()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('variations')]
        ]);

        // Create variation
        $variation = Variation::create(['name' => request('name')]);

        // Create subcategories if exists
        if (request('types')) {
            foreach (explode(',', request('types')) as $item) {
                $variation->items()->create(['name' => $item]);
            }
        }
        return back()->with('success', 'Variation created successfully');
    }

    public function update(Variation $variation)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', Rule::unique('categories')->ignore($variation->id)],
            'types' => ['sometimes', 'array'],
            'types.*.name' => ['required'],
        ]);

        // Update variation
        $variation->update(['name' => request('name')]);

        // Check for removed types and delete
        $hasError = false;
        $hasErrorCount = 0;
        foreach ($variation->items()->with(['products'])->get() as $selectedSubvariation) {
            $found = false;
            if (request('types')) {
                foreach (request('types') as $allowableSubvariation) {
                    if ($allowableSubvariation['id'] == $selectedSubvariation['id']) $found = true;
                }
            }
            if (!$found) {
                if (count($selectedSubvariation->products) == 0){
                     $selectedSubvariation->delete();
                }else{
                    $hasError = true;
                    $hasErrorCount++;
                }
            }
        }


        // Update or create subcategories
        if (request('types')) {
            foreach (request('types') as $subvariation) {
                if ($subvariation['id']){
                    $currentSubvariation = $variation->items()->where('id', $subvariation['id'])->first();
                    if ($currentSubvariation) $currentSubvariation->update(['name' => $subvariation['name']]);
                }else{
                    $variation->items()->create(['name' => $subvariation['name']]);
                }
            }
        }
        if ($hasError) $msg = 'variation updated successfully '.$hasErrorCount.' subcategories not deleted, associated products found';
        else $msg = 'variation updated successfully';
        return back()->with('success', $msg);
    }

    public function destroy(Variation $variation)
    {
        // Check if variation has associated products
        if ($variation->items()->has('products')->count() > 0) {
            return back()->with('success', 'Can\'t delete variation, associated products found');
        }
        // Delete variation and associated subcategories
        $variation->items()->delete();
        $variation->delete();
        return back()->with('success', 'variation deleted successfully');
    }
}
