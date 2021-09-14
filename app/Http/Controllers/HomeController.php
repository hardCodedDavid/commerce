<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Variation;
use App\Http\Controllers\CartController;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function recentlyViewed()
    {
        if (auth()->check())
            $products =  json_decode(auth()->user()['recent_views'], true) ?? [];
        else
            $products = json_decode(session('recent_views'), true) ?? [];
        return view('recently-viewed', compact('products'));
    }

    public function shop()
    {
        $products = Product::where('is_listed', 1)->latest();
        if (request('sort') == 'sale')
            $products = $products->orderBy('sold');
        if (request('sort') == 'price')
            $products = $products->orderBy('sell_price');
        if (request('sort') == 'name')
            $products = $products->orderBy('name');
        $products = $products->paginate(request('rpp') ?? 24);
        $from = $to = null;
        return view('shop', compact('products', 'from', 'to'));
    }

    public function filterShop()
    {
        $products = Product::where('is_listed', 1)->latest();
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
        return view('shop', compact('products', 'from', 'to'));
    }

    public function cart()
    {
        return view('cart');
    }

    public function checkout()
    {
        $delivery_fee = 0;
        $user = User::find(auth()->id());
        if ($user && $user['address'] && $user['latitude'] && $user['longitude']) {
            $delivery_fee = 2500;
//            try {
//                $delivery_fee = DeliveryController::estimateDelivery([["address" => $user['address'], "latitude" => $user['latitude'], "longitude" => $user['longitude']]])['fare'] ?? 0;
//            } catch (Exception $e) {
//                $delivery_fee = 0;
//            }
        }
        $cart = CartController::getUserCartAsArray();
        if (count($cart['items'])  < 1)
            return redirect('/cart');
        return view('checkout', compact('delivery_fee'));
    }

    public function processCheckout()
    {
        $this->validate(request(), ['delivery_method' => 'required']);

        if (request('delivery_method') == 'pickup')
            $rules = [
                'pickup_name' => 'required',
                'pickup_phone' => 'required',
                'pickup_location' => 'required'
            ];
        else
            $rules = [
                'name' => 'required',
                'email' => 'required',
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
            if (request('delivery_method') == 'pickup') $rules['pickup_email'] = 'required';
            if (request('create_account') == 'yes') {
                $rules['email'] = 'required|unique:users';
                $rules['password'] = 'required|confirmed|min:8';
            }
        }
        $this->validate(request(), $rules);

        $delivery_fee = 0;
        if (request('delivery_method') == 'ship') {
            $delivery_fee = 2500;
            if (request('ship_to_new_address')) {
                if (request('shippingCityLat') == null || request('shippingCityLng') == null)
                    return back()->with('error', 'Address could not be validated. Select a new address and try again')->withInput();
            } else {
                if (request('cityLat') == null || request('cityLng') == null)
                    return back()->with('error', 'Address could not be validated. Select a new address and try again')->withInput();
            }
        }

        if (request('create_account') == 'yes') {
            $user = User::create([
                'name' => request('name'),
                'email' => request('email'),
                'password' => Hash::make(request('password')),
            ]);
            event(new Registered($user));
        }

        if (request('delivery_method') == 'pickup') {
            $data = [
                'name' => request('pickup_name'),
                'phone' => request('pickup_phone'),
                'email' => auth()->user()['email'] ?? request('pickup_email'),
                'pickup_location' => request('pickup_location')
            ];
        }
        else {
            $data = request()->only('name', 'country', 'state', 'address', 'city', 'phone', 'email', 'note');
            $data['email'] = auth()->user()['email'] ?? request('email');
            $data['longitude'] = request('cityLng');
            $data['latitude'] = request('cityLat');
        }
        if (auth()->user()) {
            if (request('ship_to_new_address')) {
                $data = [
                    'country' => request('shipping_country'),
                    'state' => request('shipping_state'),
                    'address' => request('shipping_address'),
                    'postcode' => request('shipping_postcode'),
                    'city' => request('shipping_city'),
                    'note' => request('note'),
                    'name' => request('name'),
                    'phone' => request('phone'),
                    'email' => auth()->user()['email'] ?? request('email')
                ];
                $data['longitude'] = request('shippingCityLng');
                $data['latitude'] = request('shippingCityLat');
            }
        }
//        if (request('delivery_method') == 'ship') {
//            try {
//                $delivery_fee = DeliveryController::estimateDelivery([["address" => $data['address'], "latitude" => $data['latitude'], "longitude" => $data['longitude']]])['fare'] ?? request('delivery_fee');
//            } catch (Exception $e) {
//                $delivery_fee = request('delivery_fee');
//            }
//        }

        $data['auth'] = !is_null(auth()->user());
        $data['delivery_method'] = request('delivery_method');
        $cart = CartController::getUserCartAsArray();
        $data['cart'] = $cart;

        return PaymentController::initializeTransaction(($cart['total'] + $delivery_fee), $data);
    }

    public function estimateDeliveryCost()
    {
        return true;
        $data = [
//            "customer_name" => "Bar",
//            "customer_phone" => "+2341234567891",
//            "customer_email" => "example+1@about.com",
            [
                "address" => request('loc'),
                "latitude" => request('lat'),
                "longitude" => request('lng')
            ]
        ];
        return DeliveryController::estimateDelivery($data);
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
        $data['longitude'] = request('cityLng');
        $data['latitude'] = request('cityLat');
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
        if ($user = User::find(auth()->id())) {
            $data = json_decode($user['recent_views'], true) ?? [];
            foreach ($data as $key => $prod)
                if ($prod['id'] == $product['id'])
                    array_splice($data, $key, 1);

            $data[] = $product;
            $user->update(['recent_views' => json_encode($data)]);
        } else {
            $data = json_decode(session('recent_views'), true) ?? [];
            foreach ($data as $key => $prod)
                if ($prod['id'] == $product['id'])
                    array_splice($data, $key, 1);

//            if (count($data) > 9)
//                array_shift($data);
            $data[] = $product;
            session(['recent_views' => json_encode($data)]);
        }

        $categories = $product->categories()->get()->map(function($category){
            return $category['id'];
        });
        $related = Product::where('is_listed', 1)->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        })->where('id', '!=', $product['id'])->get();
        return view('product-detail', compact('product', 'related'));
    }

    public function storeReview(Product $product)
    {
        $this->validate(request(), [
            'review' => 'required',
            'name' => 'required'
        ]);
        if (request('email'))
            $this->validate(request(), ['email' => 'email']);

        $product->reviews()->create(request()->only('name', 'email', 'rating', 'review'));
        return back()->with('success', 'Review submitted');
    }

    public function searchProduct($val)
    {
        $products = Product::where('is_listed', 1)->where(function ($q) use ($val) {
            $q->where('name', 'LIKE', '%'.$val.'%')->orWhere('description', 'LIKE', '%'.$val.'%');
        })->get();
        return response()->json(ProductResource::collection($products));
    }

    public function getInvoice($type, $code)
    {
        if ($type == "sales") $data = Sale::where('code', $code)->first();
        else if ($type == "purchases") $data = Purchase::where('code', $code)->first();
        else throw new NotFoundHttpException;
        if (!$data) throw new NotFoundHttpException;
        $variations = Variation::all();
        return view('invoice', compact('type', 'data', 'variations'));
    }

    public function newsletter()
    {
        $this->validate(request(), ['email' => ['required', 'email']]);
        if (!DB::table('newsletter')->where('email', request('email'))->first())
            DB::table('newsletter')->insert(['email' => request('email'), 'created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'You have subscribed for '.env('APP_NAME').' newsletter');
    }

    public static function getAvatar($email)
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/$hash?d=".rawurlencode(asset('assets/img/avatar.png'));
    }
}
