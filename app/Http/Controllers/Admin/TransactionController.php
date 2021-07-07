<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Brand;

class TransactionController extends Controller
{
    public function purchases()
    {
        return view('admin.transactions.purchases.index');
    }

    public function sales()
    {
        switch (true){
            case request()->offsetExists("offline") :
                $type = "offline";
                break;
            case request()->offsetExists("online") :
                $type = "online";
                break;
            default :
                $type = null;
        }
        return view('admin.transactions.sales.index', [
            'type' => $type
        ]);
    }

    public function createPurchase()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::query()->with(['variationItems'])->get();
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.purchases.create', [
            'suppliers' =>  $suppliers,
            'products' => $products,
            'variations' => $variations
        ]);
    }

    public function createSale()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::query()->with(['variationItems'])->get();
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.sales.create', [
            'suppliers' =>  $suppliers,
            'products' => $products,
            'variations' => $variations
        ]);
    }

    public function purchaseInvoice(Purchase $purchase)
    {
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.purchases.show', [
            'purchase' => $purchase,
            'variations' => $variations
        ]);
    }

    public function saleInvoice(Sale $sale)
    {
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.sales.show', [
            'sale' => $sale,
            'variations' => $variations
        ]);
    }


    public function editPurchase(Purchase $purchase)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::query()->with(['variationItems'])->get();
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.purchases.edit', [
            'suppliers' =>  $suppliers,
            'products' => $products,
            'variations' => $variations,
            'purchase' => $purchase
        ]);
    }

    public function editSale(Sale $sale)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::query()->with(['variationItems'])->get();
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.sales.edit', [
            'suppliers' =>  $suppliers,
            'products' => $products,
            'variations' => $variations,
            'sale' => $sale
        ]);
    }

    public function storePurchase()
    {
        // Validate request
        $this->validate(request(), [
            'supplier' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
        ]);

        // Find supplier
        $supplier = Supplier::find(request('supplier'));
        if (!$supplier) {
            return back()->with('error', 'Supplier not found');
        }

        // Store purchase
        $data = request()->only('date', 'note', 'shipping_fee', 'additional_fee');
        $data['code'] = Purchase::getCode();
        $purchase = $supplier->purchases()->create($data);

        // Store purchase products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            if ($currentProduct) {
                // Store purchase items
                $item = $purchase->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);

                // Assign selected variation items to purchase item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase created successfully');
    }

    public function storeSale()
    {
        // Validate request
        $this->validate(request(), [
            'customer_name' => ['required'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
        ]);

        // Store sale
        $data = request()->only('customer_name', 'customer_email', 'customer_phone', 'customer_address', 'date', 'note', 'shipping_fee', 'additional_fee');
        $data['code'] = Sale::getCode();
        $sale = Sale::create($data);

        // Store sale products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            if ($currentProduct) {
                // Store sale items
                $item = $sale->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $currentProduct['sell_price'],
                    'profit' => $currentProduct->getProfit()
                ]);

                // Assign selected variation items to sale item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale created successfully');
    }

    public function updatePurchase(Purchase $purchase)
    {
        // Validate request
        $this->validate(request(), [
            'supplier' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
        ]);

        // Find supplier
        $supplier = Supplier::find(request('supplier'));
        if (!$supplier) {
            return back()->with('error', 'Supplier not found');
        }

        // Store purchase
        $data = request()->only('date', 'note', 'shipping_fee', 'additional_fee');
        $purchase->update($data);

        // Remove all purchase items and respective variation items
        foreach($purchase->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $item->delete();
        }

        // Store purchase products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            if ($currentProduct) {
                // Store purchase items
                $item = $purchase->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);

                // Assign selected variation items to purchase item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase updated successfully');
    }

    public function updateSale(Sale $sale)
    {
        // Check if sale is online
        if ($sale['type'] == 'online'){
            return redirect()->route('admin.transactions.sales')->with('error', 'Can\'t update online sale');
        }
        // Validate request
        $this->validate(request(), [
            'customer_name' => ['required'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
        ]);

        // Store purchase
        $data = request()->only('customer_name', 'customer_email', 'customer_phone', 'customer_address', 'date', 'note', 'shipping_fee', 'additional_fee');
        $sale->update($data);

        // Remove all sale items and respective variation items
        foreach($sale->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $item->delete();
        }

        // Store sale products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            if ($currentProduct) {
                // Store sale items
                $item = $sale->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $currentProduct['sell_price'],
                    'profit' => $currentProduct->getProfit()
                ]);

                // Assign selected variation items to sale item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
            }
        }
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale updated successfully');
    }

    public function destroyPurchase(Purchase $purchase)
    {
        // Remove all purchase items and respective variation items
        foreach($purchase->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $item->delete();
        }
        $purchase->delete();
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase deleted successfully');
    }

    public function destroySale(Sale $sale)
    {
        // Check if sale is online
        if ($sale['type'] == 'online'){
            return redirect()->route('admin.transactions.sales')->with('error', 'Can\'t delete online sale');
        }
        // Remove all purchase items and respective variation items
        foreach($sale->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $item->delete();
        }
        $sale->delete();
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale deleted successfully');
    }

    public function getPurchasesByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'code', 'id', 'id', 'id', 'date', 'id', 'id', 'id', 'id', 'id'
        ];
        $purchases = Purchase::query()->latest()->with(['items', 'supplier', 'brand']);
        //   Set helper variables from request and DB
        $totalData = $totalFiltered = $purchases->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //  Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $purchases = $purchases->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $purchases = $purchases->where('code','LIKE',"%{$search}%")
                ->orWhereHas('supplier',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhereHas('items',function ($q) use ($search) {
                    $q->where('quantity', 'LIKE',"%{$search}%")
                        ->orWhere('price', 'LIKE',"%{$search}%");
                })
                ->orWhere('date', 'LIKE',"%{$search}%")
                ->orWhere('note', 'LIKE',"%{$search}%")
                ->orWhere('shipping_fee', 'LIKE',"%{$search}%")
                ->orWhere('additional_fee', 'LIKE',"%{$search}%");
            $totalFiltered = $purchases->count();
            $purchases = $purchases->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        //   Loop through all data and mutate data
        $data = [];
        $key = $start + 1;
        foreach ($purchases as $purchase)
        {
            $datum['sn'] = $key;
            $datum['code'] = '<a href="'. route('admin.transactions.purchases.edit', $purchase) .'">'. $purchase['code'] .'</a>';
            $datum['supplier'] = $purchase['supplier']['name'];
            $datum['products'] = count($purchase['items']);
            $datum['quantity'] = $purchase->getTotalQuantity();
            $datum['date'] = $purchase['date']->format('M d, Y');
            $datum['sub_total'] = number_format($purchase->getSubTotal());
            $datum['shipping'] = $purchase['shipping_fee'] ? number_format($purchase['shipping_fee']) : '---';
            $datum['additional'] = $purchase['additional_fee'] ? number_format($purchase['additional_fee']) : '---';
            $datum['total'] = number_format($purchase->getTotal());
            $datum['action'] = '<div class="dropdown">
                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.purchases.edit', $purchase) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.purchases.invoice', $purchase) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-list-alt mr-2"></i> <span class="">Invoice</span></a>
                                        <button onclick="event.preventDefault(); confirmSubmission(\'deleteForm'.$purchase['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                        <form method="POST" id="deleteForm'.$purchase['id'].'" action="'. route('admin.transactions.purchases.destroy', $purchase) .'">
                                            <input type="hidden" name="_token" value="'. csrf_token() .'" />
                                            <input type="hidden" name="_method" value="DELETE" />
                                        </form>
                                    </div>
                                </div>';
            $data[] = $datum;
            $key++;
        }
        //   Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }

    public function getSalesByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'code', 'customer_name', 'id', 'id', 'date', 'id', 'id', 'id', 'id', 'id'
        ];

        if (request('type')){
            $sales = Sale::query()->latest()->where('type', request('type'))->with(['items']);
        }else{
            $sales = Sale::query()->latest()->with(['items']);
        }
        //   Set helper variables from request and DB
        $totalData = $totalFiltered = $sales->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //  Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $sales = $sales->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $sales = $sales->where('code','LIKE',"%{$search}%")
                ->orWhereHas('items',function ($q) use ($search) {
                    $q->where('quantity', 'LIKE',"%{$search}%")
                        ->orWhere('price', 'LIKE',"%{$search}%");
                })
                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                ->orWhere('customer_email', 'LIKE',"%{$search}%")
                ->orWhere('customer_phone', 'LIKE',"%{$search}%")
                ->orWhere('customer_address', 'LIKE',"%{$search}%")
                ->orWhere('date', 'LIKE',"%{$search}%")
                ->orWhere('note', 'LIKE',"%{$search}%")
                ->orWhere('shipping_fee', 'LIKE',"%{$search}%")
                ->orWhere('additional_fee', 'LIKE',"%{$search}%");
            $totalFiltered = $sales->count();
            $sales = $sales->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        //   Loop through all data and mutate data
        $data = [];
        $key = $start + 1;
        foreach ($sales as $sale)
        {
            $edit = $delete = null;
            if ($sale['type'] == 'offline'){
                $edit = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.sales.edit', $sale) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></a>';
                $delete = '<button onclick="event.preventDefault(); confirmSubmission(\'deleteForm'.$sale['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                <form method="POST" id="deleteForm'.$sale['id'].'" action="'. route('admin.transactions.sales.destroy', $sale) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'" />
                    <input type="hidden" name="_method" value="DELETE" />
                </form>';
            }

            $datum['sn'] = $key;
            $datum['code'] = '<a href="'. route('admin.transactions.sales.edit', $sale) .'">'. $sale['code'] .'</a>';
            $datum['customer'] = $sale['customer_name'];
            $datum['type'] = $sale['type'] == 'online' ? '<span class="badge badge-success-inverse">Online</span>' : '<span class="badge badge-secondary-inverse">Offline</span>';
            $datum['products'] = count($sale['items']);
            $datum['quantity'] = $sale->getTotalQuantity();
            $datum['date'] = $sale['date']->format('M d, Y');
            $datum['sub_total'] = number_format($sale->getSubTotal());
            $datum['shipping'] = $sale['shipping_fee'] ? number_format($sale['shipping_fee']) : '---';
            $datum['additional'] = $sale['additional_fee'] ? number_format($sale['additional_fee']) : '---';
            $datum['total'] = number_format($sale->getTotal());
            $datum['action'] = '<div class="dropdown">
                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        '.$edit.'
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.sales.invoice', $sale) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-list-alt mr-2"></i> <span class="">Invoice</span></a>
                                        '.$delete.'
                                    </div>
                                </div>';
            $data[] = $datum;
            $key++;
        }
        //   Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }
}
