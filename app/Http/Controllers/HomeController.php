<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Http\Controllers\CartController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function shop()
    {
        $products = Product::where('is_listed', 1);
        if (request('sort') == 'sale')
            $products = $products->orderBy('sold');
        if (request('sort') == 'price')
            $products = $products->orderBy('sell_price');
        if (request('sort') == 'name')
            $products = $products->orderBy('name');
        $products = $products->paginate(request('rpp') ?? 24);
        return view('shop', compact('products'));
    }

    public function filterShop()
    {
        $products = Product::where('is_listed', 1);
        $from = request('from');
        $to = request('to');
        $brands = request('brands');
        $variations = request('variations');
        if ($from && $to)
            $products->whereBetween('sell_price', [$from, $to]);
        if ($variations)
            $products->whereHas('variationItems', function ($q) use ($variations) {
                $q->whereIn('variation_items.id', $variations);
            });
        if ($brands)
            $products->whereHas('brands', function ($q) use ($brands) {
                $q->whereIn('brands.id', $brands);
            });
        $products = $products->paginate(24);
        return view('shop', compact('products'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        $cart = CartController::getUserCartAsArray();
        if (count($cart['items'])  < 1)
            return redirect('/cart');
        return view('checkout');
    }

    public function processCheckout()
    {
        $rules = [
            'name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'shipping_country' => 'required_if:ship_to_new_address,yes',
            'shipping_state' => 'required_if:ship_to_new_address,yes',
            'shipping_address' => 'required_if:ship_to_new_address,yes',
            'shipping_city' => 'required_if:ship_to_new_address,yes',
        ];
        if (!auth()->user()) {
            if (request('create_account') == 'yes'){
                $rules['email'] = 'required|unique:users';
                $rules['password'] = 'required|confirmed|min:8';
            }else $rules['email'] = 'required';
        }
        $this->validate(request(), $rules);
        if (request('create_account') == 'yes') {
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
            ]);
            event(new Registered($user));
        }
        $data = request()->only('name', 'country', 'state', 'address', 'city', 'phone', 'email', 'note');
        if (auth()->user())
            if (request('ship_to_new_address'))
                $data = request()->only('shipping_country', 'shipping_state', 'shipping_address', 'shipping_postcode', 'eshipping_citymail', 'note');
        $data['auth'] = !is_null(auth()->user());
        $data['email'] = auth()->user()['email'] ?? request('email');
        $cart = CartController::getUserCartAsArray();
        $data['cart'] = $cart;
        return PaymentController::initializeTransaction($cart['total'], $data);
    }

    public function wishlist()
    {
        return view('wishlist');
    }

    public function account()
    {
        return view('account');
    }

    public function faq()
    {
        return view('faq');
    }

    public function orderTracking()
    {
        return view('order-tracking');
    }

    public function orderSuccessful(Order $order)
    {
        return view('order-successful', compact('order'));
    }

    public function trackOrder()
    {
        $this->validate(request(), [
            'order_id' => 'required',
            'email' => 'required|email',
        ]);
        $order = Order::where('email', request('email'))->where('code', request('order_id'))->first();
        if (!$order) {
            return back()->with('error', 'We couldn\'t find an order with this ID and email address');
        }
        return view('order-tracker', compact('order'));
    }

    public function updateAccount()
    {
        $this->validate(request(), [
            'name' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $data = request()->only('name', 'country', 'state', 'city', 'address', 'phone', 'postcode');
        auth()->user()->update($data);
        return back()->with('success', 'Profile updated successfully');
    }

    public function changePassword()
    {
        $this->validate(request(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        if (!Hash::check(request('old_password'), auth()->user()['password']))
            return back()->with('error', 'Old password incorrect');
        auth()->user()->update([
            'password' => Hash::make(request('new_password'))
        ]);
        return back()->with('success', 'Password changed successfully');
    }

    public function orders()
    {
        return view('orders');
    }

    public function showOrder(Order $order)
    {
        return view('order-detail', compact('order'));
    }

    public function productDetail(Product $product)
    {
        $categories = $product->categories()->get()->map(function($category){
            return $category['id'];
        });
        $related = Product::where('is_listed', 1)->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        })->where('id', '!=', $product['id'])->get();
        return view('product-detail', compact('product', 'related'));
    }

    public function searchProduct($val)
    {
        $products = Product::where('is_listed', 1)->where(function ($q) use ($val) {
            $q->where('name', 'LIKE', '%'.$val.'%')->orWhere('description', 'LIKE', '%'.$val.'%');
        })->get();
        return response()->json(ProductResource::collection($products));
    }
}
