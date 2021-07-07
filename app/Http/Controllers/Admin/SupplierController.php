<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.suppliers.index', [
            'suppliers' => Supplier::latest()->with(['purchases'])->get()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', 'string', 'unique:suppliers,name'],
            'email' => ['sometimes', 'email']
        ]);

        // Store supplier
        Supplier::create(request()->all());
        return back()->with('success', 'Supplier created successfully');
    }

    public function update(Supplier $supplier)
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', 'string', Rule::unique('suppliers')->ignore($supplier->id)],
            'email' => ['sometimes', 'email']
        ]);

        // update supplier
        $supplier->update(request()->all());
        return back()->with('success', 'Supplier update successfully');
    }

    public function destroy(Supplier $supplier)
    {
        // Check if supplier has purchases
        if ($supplier->purchases()->count() > 0) {
            return back()->with('error', 'Can\'t delete supplier, associated purchases found');
        }

        // delete supplier
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully');
    }
}
