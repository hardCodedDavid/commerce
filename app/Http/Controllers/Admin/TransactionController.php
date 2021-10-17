<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Variation;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

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
        $suppliers = Supplier::query()->orderBy('name')->get();
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
        $suppliers = Supplier::query()->orderBy('name')->get();
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
        $suppliers = Supplier::query()->orderBy('name')->get();
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
        $suppliers = Supplier::query()->orderBy('name')->get();
        $products = Product::query()->with(['variationItems'])->get();
        $variations = Variation::query()->with(['items'])->get();
        return view('admin.transactions.sales.edit', [
            'suppliers' =>  $suppliers,
            'products' => $products,
            'variations' => $variations,
            'sale' => $sale
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function storePurchase(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'supplier' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required'],
//            'products.*.item_numbers' => ['required', 'array'],
            'products.*.item_numbers.*' => ['required', 'unique:item_numbers,no']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
            'products.*.item_numbers.*.required' => 'The item number field is required',
            'products.*.item_numbers.*.unique' => 'The item number already exist',
        ]);

        $numbers = [];
        $errors = [];
        foreach (request('products') as $key => $product)
            foreach ($product['item_numbers'] as $curKey => $number)
                $numbers[$number][] = $key.$curKey;

        foreach (request('products') as $key => $product)
            foreach ($product['item_numbers'] as $curKey => $number)
                if (count($numbers[$number]) > 1)
                    $errors['products.'.$key.'.item_numbers.'.$curKey] = 'The item number must be unique';

        if (count($errors) > 0)
            return back()->withInput()->withErrors($errors);

        // Find supplier
        $supplier = Supplier::find(request('supplier'));
        if (!$supplier) {
            return back()->with('error', 'Supplier not found');
        }

        // Store purchase
        $data = request()->only('date', 'note', 'shipping_fee', 'additional_fee');
        $data['code'] = Purchase::getCode();
        $data['created_by'] = auth('admin')->id();
        $purchase = $supplier->purchases()->create($data);

        // Store purchase products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            $itemNumbers = $product['item_numbers'];
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
                $currentProduct->update(['quantity' => $currentProduct['quantity'] + abs($product['quantity'])]);
                foreach ($itemNumbers as $itemNumber)
                    $currentProduct->itemNumbers()->create(['purchase_item_id' => $item['id'], 'no' => $itemNumber]);
            }
        }
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase created successfully');
    }

    /**
     * @throws ValidationException
     */
    public function storeSale(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'customer_name' => ['required'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required'],
            'products.*.item_numbers' => ['required', 'array']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
            'products.*.item_numbers.required' => 'The item number field is required',
        ]);

        $errors = [];
        $numbers = [];
        foreach (request('products') as $key => $product)
            if (isset($product['item_numbers'])) {
                if (count($product['item_numbers']) != $product['quantity'])
                    $errors['products.' . $key . '.quantity'] = 'The item numbers must be equal to the quantity';
                foreach ($product['item_numbers'] as $curKey => $number)
                    $numbers[$number][] = $key.$curKey;
            }

        foreach (request('products') as $key => $product)
            if (isset($product['item_numbers']))
                foreach ($product['item_numbers'] as $number)
                    if (count($numbers[$number]) > 1)
                        $errors['products.'.$key.'.item_numbers'] = 'Item number selected in multiple places';

        if (count($errors) > 0)
            return back()->withInput()->withErrors($errors);

        // Store sale
        $data = request()->only('customer_name', 'customer_email', 'customer_phone', 'customer_address', 'date', 'note', 'shipping_fee', 'additional_fee');
        $data['code'] = Sale::getCode();
        $data['created_by'] = auth('admin')->id();
        $sale = Sale::create($data);

        // Store sale products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            $itemNumbers = $product['item_numbers'];
            $numbers = [];
            if ($currentProduct) {
                // Store sale items
                $item = $sale->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $currentProduct['sell_price'],
                    'profit' => $currentProduct->getProfit() * $product['quantity']
                ]);

                foreach ($itemNumbers as $itemNumber) {
                    $number = ItemNumber::find($itemNumber);
                    if ($number) {
                        $numbers[] = [$number['id'] => $number['no']];
                        $number->update(['sale_item_id' => $item['id'], 'status' => 'sold', 'date_sold' => now()]);
                    }
                }

                $item->update(['item_numbers' => json_encode($numbers)]);

                // Assign selected variation items to sale item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
                $currentProduct->update(['quantity' => $currentProduct['quantity'] - abs($product['quantity'])]);
            }
        }
        self::sendSaleSMS($sale);
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale created successfully');
    }

    /**
     * @throws ValidationException
     */
    public function updatePurchase(Purchase $purchase): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'supplier' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required'],
            'products.*.old_item_numbers' => ['required', 'array'],
            'products.*.old_item_numbers.*.no' => ['required_with:products.*.old_item_numbers'],
            'products.*.item_numbers' => ['array', 'min:1'],
            'products.*.item_numbers.*' => ['required_with:products.*.item_numbers', 'unique:item_numbers,no']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
            'products.*.old_item_numbers.*.no.required_with' => 'The item number field is required',
            'products.*.item_numbers.*.required_with' => 'The item number field is required',
            'products.*.item_numbers.*.unique' => 'The item number already exist',
        ]);
        $numbers = [];
        $oldNumbers = [];
        $newErrors = [];
        $oldErrors = [];
        foreach (request('products') as $key => $product) {
            if (isset($product['item_numbers']))
                foreach ($product['item_numbers'] as $curKey => $number)
                    $numbers[$number][] = $key . $curKey;

            if (isset($product['old_item_numbers']))
                foreach ($product['old_item_numbers'] as $curKey => $number)
                    $oldNumbers[$number['no']][] = $key . $curKey;
        }

        foreach (request('products') as $key => $product) {
            if (isset($product['item_numbers']))
                foreach ($product['item_numbers'] as $curKey => $number)
                    if (count($numbers[$number]) > 1)
                        $newErrors['products.' . $key . '.item_numbers.' . $curKey] = 'The item number must be unique';

            if (isset($product['old_item_numbers']))
                foreach ($product['old_item_numbers'] as $curKey => $number)
                    if (count($oldNumbers[$number['no']]) > 1)
                        $oldErrors['products.' . $key . '.old_item_numbers.' . $curKey . '.no'] = 'The item number already exist';
        }
        $errors = array_merge($oldErrors, $newErrors);
        if (count($errors) > 0)
            return back()->withInput()->withErrors($errors);

        // Find supplier
        $supplier = Supplier::find(request('supplier'));
        if (!$supplier) {
            return back()->with('error', 'Supplier not found')->withInput();
        }

        // Store purchase
        $data = request()->only('date', 'note', 'shipping_fee', 'additional_fee');
        if (!$purchase['updated_by']) {
            $data['updated_by'] = auth('admin')->id();
            $data['updated_date'] = now();
        }
        $data['last_updated_by'] = auth('admin')->id();
        $purchase->update($data);

        // Remove all purchase items and respective variation items
        foreach($purchase->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $item->delete();
        }

        // Store purchase products
        $variations = Variation::all();
        foreach (request('products') as $key => $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            $oldItemNumbers = $product['old_item_numbers'] ?? [];
            $newItemNumbers = $product['item_numbers'] ?? [];
            logger($oldItemNumbers);
            logger($newItemNumbers);
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

                if ($oldItemNumbers)
                    foreach ($oldItemNumbers as $number) {
                        $itemNumber = ItemNumber::find($number['id']);
                        if ($itemNumber && $itemNumber['product_id'] == $currentProduct['id'])
                            $itemNumber->update(['purchase_item_id' => $item['id'], 'no' => $number['no']]);
                    }

                if ($newItemNumbers)
                    foreach ($newItemNumbers as $number)
                        if ($number)
                            $currentProduct->itemNumbers()->create(['purchase_item_id' => $item['id'], 'no' => $number]);
            }
            if ($key == 0)
                $currentProduct->update(['quantity' => $product['quantity']]);
            else
                $currentProduct->update(['quantity' => $currentProduct['quantity'] + $product['quantity']]);
        }
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function updateSale(Sale $sale): RedirectResponse
    {
        // Check if sale is online
        if ($sale['type'] == 'online') {
            return redirect()->route('admin.transactions.sales')->with('error', 'Can\'t update online sale');
        }
        // Validate request
        $this->validate(request(), [
            'customer_name' => ['required'],
            'date' => ['required', 'date'],
            'products' => ['required', 'array'],
            'products.*.product' => ['required'],
            'products.*.quantity' => ['required'],
            'products.*.price' => ['required'],
            'products.*.old_item_numbers' => ['required', 'array'],
            'products.*.item_numbers' => ['sometimes', 'array']
        ],[
            'products.*.product.required' => 'The product field is required',
            'products.*.quantity.required' => 'The quantity field is required',
            'products.*.price.required' => 'The price field is required',
            'products.*.old_item_numbers.required' => 'The old item number field is required',
            'products.*.item_numbers.sometimes' => 'The item number field is required',
        ]);

        $numbers = [];
        $errors = [];
        foreach (request('products') as $key => $product) {
            if (isset($product['item_numbers']))
                foreach ($product['item_numbers'] as $curKey => $number)
                    $numbers[$number][] = $key . $curKey;

            if (count($product['item_numbers'] ?? []) + count($product['old_item_numbers'] ?? []) != $product['quantity'])
                $errors['products.' . $key . '.quantity'] = 'The item numbers must be equal to the quantity';
        }

        foreach (request('products') as $key => $product)
            if (isset($product['item_numbers']))
                foreach ($product['item_numbers'] as $number)
                    if (count($numbers[$number]) > 1)
                        $errors['products.'.$key.'.item_numbers'] = 'Item number selected in multiple places';


        if (count($errors) > 0)
            return back()->withInput()->withErrors($errors);

        // Store purchase
        $data = request()->only('customer_name', 'customer_email', 'customer_phone', 'customer_address', 'date', 'note', 'shipping_fee', 'additional_fee');
        if (!$sale['updated_by']) {
            $data['updated_by'] = auth('admin')->id();
            $data['updated_date'] = now();
        }
        $data['last_updated_by'] = auth('admin')->id();
        $sale->update($data);

        $qtyArr = [];
        // Remove all sale items and respective variation items
        foreach($sale->items()->get() as $item) {
            $item->variationItems()->sync([]);
            $qtyArr[$item['product_id'].'_'.$item['id']] = $item['quantity'];
            $item->delete();
        }

        // Store sale products
        $variations = Variation::all();
        foreach (request('products') as $product) {
            // Get the current product
            $currentProduct = Product::find($product['product']);
            $newItemNumbers = $product['item_numbers'] ?? [];
            $oldItemNumbers = $product['old_item_numbers'] ?? [];
            $numbers = [];
            if ($currentProduct) {
                // Store sale items
                $item = $sale->items()->create([
                    'product_id' => $product['product'],
                    'brand_id' => $product['brand'],
                    'quantity' => $product['quantity'],
                    'price' => $currentProduct['sell_price'],
                    'profit' => $currentProduct->getProfit() * $product['quantity']
                ]);

                foreach ($oldItemNumbers as $itemNumber) {
                    $number = ItemNumber::find($itemNumber['id']);
                    if ($number) {
                        $oldItemId = $number['sale_item_id'];
                        $numbers[] = [$number['id'] => $number['no']];
                        $number->update(['sale_item_id' => $item['id']]);
                    }
                }

                foreach ($newItemNumbers as $itemNumber) {
                    $number = ItemNumber::find($itemNumber);
                    if ($number) {
                        $numbers[] = [$number['id'] => $number['no']];
                        $number->update(['sale_item_id' => $item['id'], 'status' => 'sold', 'date_sold' => now()]);
                    }
                }

                $item->update(['item_numbers' => json_encode($numbers)]);

                // Assign selected variation items to sale item
                foreach ($currentProduct->variationItems()->get() as $currentVariationItem) {
                    foreach ($variations as $variation) {
                        $currentId = $product[$variation['name']];
                        if ($currentId && $currentId == $currentVariationItem['id']){
                            $item->variationItems()->attach($currentId);
                        }
                    }
                }
                $newQty = $currentProduct['quantity'] - ($product['quantity'] - $qtyArr[$currentProduct['id'].'_'.$oldItemId]);
                $newQty = $newQty < 0 ? 0 : $newQty;
                $currentProduct->update(['quantity' => $newQty]);
            }
        }
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale updated successfully');
    }

    public function destroyPurchase(Purchase $purchase): RedirectResponse
    {
        foreach($purchase->items()->get() as $item) {
            $itemNumbers = $item->itemNumbers;
            foreach ($itemNumbers as $itemNumber)
                if ($itemNumber['status'] == 'sold')
                    return back()->with('error', 'Cannot delete purchase, one or more product has been sold from this purchase');
        }
        // Remove all purchase items and respective variation items
        foreach($purchase->items()->get() as $item) {
            $product = $item->product;
            $item->itemNumbers()->delete();
            $item->variationItems()->sync([]);
            $product->update(['quantity' => $product['quantity'] - $item['quantity']]);
            $item->delete();
        }
        $purchase->delete();
        return redirect()->route('admin.transactions.purchases')->with('success', 'Purchase deleted successfully');
    }

    public function destroySale(Sale $sale): RedirectResponse
    {
        // Check if sale is online
        if ($sale['type'] == 'online'){
            return redirect()->route('admin.transactions.sales')->with('error', 'Can\'t delete online sale');
        }
        // Remove all purchase items and respective variation items
        foreach($sale->items()->get() as $item) {
            $product = $item->product;
            $itemNumbers = json_decode($item['item_numbers'] ?? '', true);
            foreach ($itemNumbers as $itemNumber) {
                $number = ItemNumber::find(array_keys($itemNumber)[0]);
                if ($number)
                    $number->update(['sale_item_id' => null, 'status' => 'available', 'date_sold' => null]);
            }
            $product->update(['quantity' => $product['quantity'] + $item['quantity']]);
            $item->variationItems()->sync([]);
            $item->delete();
        }
        $sale->delete();
        return redirect()->route('admin.transactions.sales')->with('success', 'Sale deleted successfully');
    }

    public function removeItemNumber($id): JsonResponse
    {
        $itemNumber = ItemNumber::find($id);
        if (!$itemNumber)
            return response()->json(['success' => false, 'msg' => 'Item number not found'], 404);
        if ($itemNumber->saleItem->itemNumbers()->count() <= 1)
            return response()->json(['success' => false, 'msg' => 'Can\'t remove item number, sale must have at least 1 item number'], 400);

        if ($itemNumber->update(['status' => 'available', 'date_sold' => null, 'sale_item_id' => null])) {
            $numbers = [];
            foreach (json_decode($itemNumber->saleItem->item_numbers, true) as $item)
                if ($itemNumber['id'] != array_keys($item)[0])
                    $numbers[] = [array_keys($item)[0] => array_values($item)[0]];
            $itemNumber->saleItem->update(['item_numbers' => json_encode($numbers)]);
            $itemNumber->product->update(['quantity' => $itemNumber->product->quantity + 1]);
            return response()->json([
                'success' => true,
                'msg' => 'Item number removed',
                'count' => $itemNumber->purchaseItem->itemNumbers()->count(),
                'itemNumbers' => $itemNumber->product->itemNumbers()->where('status', 'available')->get()->map(function ($item) { return ['id' => $item['id'], 'no' => $item['no']]; })
            ]);
        }

        return response()->json(['success' => false, 'msg' => 'Item number could not be removed, try again'], 400);
    }

    public function deleteItemNumber($id): JsonResponse
    {
        $itemNumber = ItemNumber::find($id);
        if (!$itemNumber)
            return response()->json(['success' => false, 'msg' => 'Item number not found'], 404);

        if ($itemNumber->delete()) {
            $itemNumber->purchaseItem()->update(['quantity' => $itemNumber->purchaseItem->quantity - 1]);
            $itemNumber->product()->update(['quantity' => $itemNumber->product->quantity - 1]);
            return response()->json([
                'success' => true,
                'msg' => 'Item number deleted',
                'count' => $itemNumber->purchaseItem->itemNumbers()->count(),
                'quantity' => $itemNumber->purchaseItem->quantity - 1]);
        }

        return response()->json(['success' => false, 'msg' => 'Item number could not be deleted, try again'], 400);
    }

    public function getPurchasesByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'code', 'id', 'created_by', 'id', 'id', 'date', 'id', 'id', 'id', 'id', 'id'
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
            $edit = $delete = '';
            if (auth()->user()->can("Edit Purchases")) {
                $edit = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.purchases.edit', $purchase) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></a>';
            }
            if (auth()->user()->can("Delete Purchases")) {
                $delete = '<button onclick="event.preventDefault(); confirmSubmission(\'deleteForm'.$purchase['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>';
            }
            $datum['sn'] = $key;
            $datum['code'] = '<a href="'. route('admin.transactions.purchases.edit', $purchase) .'">'. $purchase['code'] .'</a>';
            $datum['supplier'] = $purchase['supplier']['name'];
            $datum['creator'] = $purchase->getCreatedBy();
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
                                        '.$edit.'
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.purchases.invoice', $purchase) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-list-alt mr-2"></i> <span class="">Invoice</span></a>
                                        '.$delete.'
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
            'id', 'code', 'customer_name', 'created_by', 'id', 'id', 'date', 'id', 'id', 'id', 'id', 'id'
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
            $edit = $delete = '';
            if ($sale['type'] == 'offline'){
                if (auth()->user()->can("Edit Sales")) {
                    $edit = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.sales.edit', $sale) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></a>';
                }
                if (auth()->user()->can("Delete Sales")) {
                    $delete = '<button onclick="event.preventDefault(); confirmSubmission(\'deleteForm'.$sale['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                    <form method="POST" id="deleteForm'.$sale['id'].'" action="'. route('admin.transactions.sales.destroy', $sale) .'">
                        <input type="hidden" name="_token" value="'. csrf_token() .'" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>';
                }
                $show = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.transactions.sales.invoice', $sale) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-list-alt mr-2"></i> <span class="">Invoice</span></a>';
            } else {
                $show = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.orders.show', $sale['order']['id']) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-list-alt mr-2"></i> <span class="">View</span></a>';
            }

            $datum['sn'] = $key;
            $datum['code'] = '<a href="'. route('admin.transactions.sales.edit', $sale) .'">'. $sale['code'] .'</a>';
            $datum['customer'] = $sale['customer_name'];
            $datum['creator'] = $sale->getCreatedBy();
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
                                        '.$show.'
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

    public static function sendSaleSMS($sale) {
        if ($phone = $sale['customer_phone']) {
            $sid = env('TWILIO_ACCOUNT_ID');
            $token = env('TWILIO_AUTH_TOKEN');
            try {
                $client = new Client($sid, $token);
                $client->messages->create(
                    $phone,
                    [
                        'from' => 'EmeraldFarm',
                        'body' => 'Your purchase from '.env('APP_NAME').' was successful, your transaction ID is '.$sale['code']
                    ]
                );
            }catch (\Exception $e) {
                $error = $e;
            }
        }
    }
}
