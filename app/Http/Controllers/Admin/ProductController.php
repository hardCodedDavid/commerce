<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Variation;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'type' => 'all'
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $variations = Variation::query()->with(['items'])->get();
        $brands = Brand::all();
        return view('admin.products.create',[
            'categories' => $categories,
            'variations' => $variations,
            'brands' => $brands
        ]);
    }

    public function listed()
    {
        return view('admin.products.listed', [
            'type' => 'listed'
        ]);
    }

    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $variations = Variation::query()->with(['items'])->get();
        $brands = Brand::all();
        return view('admin.products.edit',[
            'categories' => $categories,
            'variations' => $variations,
            'brands' => $brands,
            'product' => $product
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', 'string', 'unique:products,name'],
            'description' => ['required'],
            'full_description' => ['required'],
            'buy_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric', 'gte:buy_price'],
            'discount' => ['required', 'numeric'],
            'in_stock' => ['required', 'string'],
//            'quantity' => ['required', 'numeric'],
//            'item_number' => ['required', 'unique:products,item_number'],
            'weight' => ['numeric'],
            'categories' => ['required', 'array'],
            'media' => ['required', 'array', 'max:5'],
            'media.*' => ['file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Create Product
        $data = request()->only('name', 'description', 'full_description', 'buy_price', 'sell_price', 'discount', 'sku', 'weight', 'note');
        $data['code'] = Product::getCode();
        $data['in_stock'] = request('in_stock') == 'instock';
        $data['is_listed'] = request('feature') == 'feature';
        $data['created_by'] = auth('admin')->id();
        $product = Product::create($data);

        // // Save Categories
        $product->categories()->attach(request('categories'));

        // // Save SubCategories
        $product->subCategories()->attach(request('subcategories'));

        // // Save Brands
        $product->brands()->attach(request('brands'));

        // // Save Variation Items
        $product->variationItems()->attach(request('variations'));

        // Save Media
        foreach (request('media') as $key=>$file){
            $path = self::saveFileAndReturnPath($file, $product['code'].$key);
            $product->media()->create(['url' => $path]);
        }
        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }

    public function feature(Product $product): RedirectResponse
    {
        $product->update(['is_listed' => 1]);
        return redirect()->route('admin.products')->with('success', 'Product featured successfully');
    }

    public function unlist(Product $product): RedirectResponse
    {
        $product->update(['is_listed' => 0]);
        return redirect()->route('admin.products')->with('success', 'Product unlisted successfully');
    }

    public function removeMedia(Product $product): JsonResponse
    {
        if ($product->media()->count() > 1) {
            $product->media()->where('id', request('id'))->delete();
        }
        return response()->json($product->media()->get()->map(function($media){
            return [
                'id' => $media['id'],
                'url' => asset($media['url'])
            ];
        }));
    }

    public function getProductDetails(Product $product): JsonResponse
    {
        $product['brands'] = $product->brands()->get()->map(function($brand){
            return [
                'id' => $brand['id'],
                'name' => $brand['name']
            ];
        });
        $product['itemNumbers'] = $product->itemNumbers()->where('status', 'available')->get()->map(function($item){
            return [
                'id' => $item['id'],
                'no' => $item['no']
            ];
        });
        $variations = [];
        foreach (Variation::all() as $variation) {
            $variations[$variation['name']] = $product->variationItems()->where('variation_id', $variation['id'])->get()->map(function($item) {
                return [
                    'id' => $item['id'],
                    'name' => $item['name']
                ];
            });
        }
        $product['variations'] = $variations;
        return response()->json($product);
    }

    /**
     * @throws ValidationException
     */
    public function update(Product $product): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required', 'string', Rule::unique('products')->ignore($product->id)],
            'description' => ['required'],
            'full_description' => ['required'],
            'buy_price' => ['required', 'numeric'],
            'sell_price' => ['required', 'numeric', 'gte:buy_price'],
            'discount' => ['required', 'numeric'],
            'in_stock' => ['required', 'string'],
//            'quantity' => ['required', 'numeric'],
//            'item_number' => ['required', Rule::unique('products')->ignore($product->id)],
            'weight' => ['numeric'],
            'categories' => ['required', 'array'],
            'media' => ['sometimes', 'array', 'max:'.(5 - $product->media()->count())],
            'media.*' => ['file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Create Product
        $data = request()->only('name', 'description', 'full_description', 'buy_price', 'sell_price', 'discount', 'sku', 'weight', 'note');
        $data['in_stock'] = request('in_stock') == 'instock';
        $data['is_listed'] = request('feature') == 'feature';
        if (!$product['updated_by']) {
            $data['updated_by'] = auth('admin')->id();
            $data['updated_date'] = now();
        }
        $data['last_updated_by'] = auth('admin')->id();
        $product->update($data);

        // // Save Categories
        $product->categories()->sync(request('categories'));

        // // Save SubCategories
        $product->subCategories()->sync(request('subcategories'));

        // // Save Brands
        $product->brands()->sync(request('brands'));

        // // Save Variation Items
        $product->variationItems()->sync(request('variations'));

        // Save Media
        if (request('media')){
            foreach (request('media') as $key=>$file){
                $path = self::saveFileAndReturnPath($file, $product['code'].$key);
                $product->media()->create(['url' => $path]);
            }
        }
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }


    public function getProductsByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'name', 'created_by', 'buy_price', 'sell_price', 'discount', 'sku', 'in_stock', 'quantity', 'weight', 'id', 'id', 'id'
        ];
        //    Find data based on page
        if (request('type') == 'listed'){
            $products = Product::query()->where('is_listed', 1)->with(['variationItems']);
        }else{
            $products = Product::query()->with(['variationItems']);
        }
        //   Set helper variables from request and DB
        $totalData = $totalFiltered = $products->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //  Check if request wants to search or not and fetch data
        if(!empty($search)) {
            $products = $products->where('code', 'LIKE', "%{$search}%")
                ->orWhereHas('variationItems', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('brands', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('buy_price', 'LIKE', "%{$search}%")
                ->orWhere('sell_price', 'LIKE', "%{$search}%")
                ->orWhere('discount', 'LIKE', "%{$search}%")
                ->orWhere('sku', 'LIKE', "%{$search}%")
                ->orWhere('quantity', 'LIKE', "%{$search}%")
                ->orWhere('weight', 'LIKE', "%{$search}%");
            $totalFiltered = $products->count();
        }
        $products = $products->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        //   Loop through all data and mutate data
        $data = [];
        $key = $start + 1;
        foreach ($products as $product)
        {
            $variations = $brands = null;
            foreach ($product->variationItems()->get() as $item) {
                $variations .= '<span class="small badge badge-secondary-inverse mx-1">'. $item['name'] .'</span>';
            }
            foreach ($product->brands()->get() as $brand) {
                $brands .= '<span class="small badge badge-secondary-inverse mx-1">'. $brand['name'] .'</span>';
            }
            $edit = $delete = $action = '';
            if ($product['is_listed'] == 0){
                if (auth()->user()->can("Unlist Products")) {
                    $action = '<button onclick="event.preventDefault(); confirmSubmission(\'featureForm' . $product['id'] . '\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-rocket mr-2"></i> <span class="">Feature</span></button>
                            <form method="POST" id="featureForm' . $product['id'] . '" action="' . route('admin.products.feature', $product) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <input type="hidden" name="_method" value="PUT" />
                            </form>';
                }
            }else{
                if (auth()->user()->can("List Products")) {
                    $action = '<button onclick="event.preventDefault(); confirmSubmission(\'unlistForm' . $product['id'] . '\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-reply mr-2"></i> <span class="">Unlist</span></button>
                            <form method="POST" id="unlistForm' . $product['id'] . '" action="' . route('admin.products.unlist', $product) . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                <input type="hidden" name="_method" value="PUT" />
                            </form>';
                }
            }
            if (auth()->user()->can("Edit Products")) {
                $edit = '<a class="dropdown-item d-flex align-items-center" href="'. route('admin.products.edit', $product) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></a>';
            }
            if (auth()->user()->can("Delete Products")) {
                $delete = '<button onclick="event.preventDefault(); confirmSubmission(\'deleteForm'.$product['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>';
            }

            $datum['sn'] = $key;
            $datum['name'] = '<a class="font-weight-bold" href="'. route('admin.products.show', $product) .'">'. $product['name'] .'</a>';
            $datum['creator'] = $product->getCreatedBy();
            $datum['buy_price'] = $product['buy_price'];
            $datum['sell_price'] = $product['sell_price'];
            $datum['discount'] = $product['discount'];
            $datum['sku'] = $product['sku'] ?? '---';
            $datum['in_stock'] = $product['in_stock'] == 1 ? '<span class="small text-success">In stock</span>' : '<span class="small text-danger">Out of stock</span>';
            $datum['quantity'] = $product['quantity'];
            $datum['weight'] = $product['weight'];
            $datum['brands'] = $brands ?? '---';
            $datum['variations'] = $variations ?? '---';
            $datum['status'] = $product['is_listed'] == 1 ? '<span class="small badge badge-success-inverse">Featured</span>' : '<span class="small badge badge-danger-inverse">Not Featured</span>';
            $datum['action'] = '<div class="dropdown">
                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.products.show', $product) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>
                                        '.$edit.'
                                        '.$delete.'
                                        '.$action.'
                                        <form method="POST" id="deleteForm'.$product['id'].'" action="'. route('admin.products.destroy', $product) .'">
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

    public static function saveFileAndReturnPath($file, $code): string
    {
        $destination = 'media';
        $transferFile = $code.'-'.time().'.'.$file->getClientOriginalExtension();
        if (!file_exists($destination)) File::makeDirectory($destination);
        $image = Image::make($file);
        $image->save($destination . '/' . $transferFile, 60);
        return $destination . '/' . $transferFile;
    }

    public static function resizeImageAndReturnPath($file, $code, $width, $height = null, $destination = 'media'): string
    {
        $transferFile = $code.'-'.time().'.'.$file->getClientOriginalExtension();
        if (!file_exists($destination)) mkdir($destination, 666, true);
        $imgFile = Image::make($file->getRealPath());

        $imgFile->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destination.'/'.$transferFile);

        return $destination . '/' . $transferFile;
    }
}
