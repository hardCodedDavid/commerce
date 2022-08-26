<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Variation;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Home');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('home'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('Home');
        OpenGraph::setUrl(route('home'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('Home');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

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
        SEOMeta::setTitle('Shop');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('shop'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('Shop');
        OpenGraph::setUrl(route('shop'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('Shop');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

        $products = Product::query()->where('is_listed', 1)->latest();
        if (request('sort') == 'price')
            $products = $products->orderBy('sell_price');
        if (request('sort') == 'sale')
            $products = $products->orderBy('sold');
        if (request('sort') == 'name')
            $products = $products->orderBy('name');
        $products = $products->paginate(request('rpp') ?? 24);
        $from = $to = null;
        return view('shop', compact('products', 'from', 'to'));
    }

    public function filterShop()
    {
        $products = Product::query()->where('is_listed', 1)->latest();
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
//        $user = User::find(auth()->id());
//        if ($user && $user['address'] && $user['latitude'] && $user['longitude']) {
//            $delivery_fee = 2500;
//            try {
//                $delivery_fee = DeliveryController::estimateDelivery([["address" => $user['address'], "latitude" => $user['latitude'], "longitude" => $user['longitude']]])['fare'] ?? 0;
//            } catch (Exception $e) {
//                $delivery_fee = 0;
//            }
//        }
        $cart = CartController::getUserCartAsArray();
        if (count($cart['items'])  < 1)
            return redirect('/cart');
        $delivery_fee = 0;
        $weight = 0;
        foreach ($cart['items'] as $item)
            $weight += $item['product']['weight'] * $item['quantity'];
        $additional_fee = 0.01 * $cart['total'];

        return view('checkout', compact('delivery_fee', 'weight', 'additional_fee'));
    }

    /**
     * @throws ValidationException
     */
    public function processCheckout(): RedirectResponse
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
//                'shipping_country' => 'required_if:ship_to_new_address,yes',
//                'shipping_state' => 'required_if:ship_to_new_address,yes',
//                'shipping_address' => 'required_if:ship_to_new_address,yes',
//                'shipping_city' => 'required_if:ship_to_new_address,yes',
            ];
        if (!auth()->user()) {
            if (request('delivery_method') == 'pickup') $rules['pickup_email'] = 'required';
            if (request('create_account') == 'yes') {
                $rules['email'] = 'required|unique:users';
                $rules['password'] = 'required|confirmed|min:8';
            }
        }

        $this->validate(request(), $rules);

        $cart = CartController::getUserCartAsArray();
        $weight = 0;
        foreach ($cart['items'] as $item)
            $weight += $item['product']['weight'] * $item['quantity'];
        $errors = null;
        $shipmentItems = [];
        foreach($cart['items'] as $item) {
            if ($item['product']['quantity'] < $item['quantity'])
                $errors .= $item['product']['name'] . ', ';

            $shipmentItems[] = ['ItemName' => $item['product']['name'], 'ItemUnitCost' => $item['product']->getDiscountedPrice(), 'ItemQuantity' => $item['quantity']];
        }
        if ($errors)
            return back()->with('error', 'Can\'t checkout, quantities not available for '.$errors)->withInput();

//        if (request('delivery_method') == 'ship') {
//            $delivery_fee = 2500;
//            if (request('ship_to_new_address')) {
//                if (request('shippingCityLat') == null || request('shippingCityLng') == null)
//                    return back()->with('error', 'Address could not be validated. Select a new address and try again')->withInput();
//            } else {
//                if (request('cityLat') == null || request('cityLng') == null)
//                    return back()->with('error', 'Address could not be validated. Select a new address and try again')->withInput();
//            }
//        }

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
            $data = request()->only('name', 'country', 'state', 'address', 'phone', 'email', 'note');
            $data['region'] = explode('_', request('region'))[1];
            $data['town'] = explode('_', request('city'))[0];
            $data['city'] = explode('_', request('city'))[1];
            $data['email'] = auth()->user()['email'] ?? request('email');
            $data['payment_type'] = request()->has('payment_type') ? 'pay_on_delivery' : 'prepaid';
            $settings = Setting::query()->first();
            $data['CNS'] = [
//                'OrderNo' => 'ORD-1658705',
                'Description' => env('APP_NAME').' Checkout',
                'Weight' => $weight,
                'SenderName' => $settings->name ?? env('APP_NAME'),
                'SenderCity' => env('CNS_CITY'),
                'SenderTownID' => env('CNS_TOWN_ID'),
                'SenderAddress' => env('CNS_ADDRESS'),
                'SenderPhone' => $settings->phone_1,
                'SenderEmail' => $settings->email,
                'RecipientName' => $data['name'],
                'RecipientCity' => $data['region'],
                'RecipientTownID' => $data['town'],
                'RecipientAddress' => $data['address'],
                'RecipientPhone' => $data['phone'],
                'RecipientEmail' => $data['email'],
                'PaymentType' => $data['payment_type'] == 'pay_on_delivery' ? 'Pay On Delivery' : $data['payment_type'],
                'DeliveryType' => 'Normal Delivery',
                'PickupType' => 1,
                'ShipmentItems' => $shipmentItems
            ];
            $data['longitude'] = request('cityLng');
            $data['latitude'] = request('cityLat');
        }
//        if (auth()->user()) {
//            if (request('ship_to_new_address')) {
//                $data = [
//                    'country' => request('shipping_country'),
//                    'state' => request('shipping_state'),
//                    'address' => request('shipping_address'),
//                    'postcode' => request('shipping_postcode'),
//                    'city' => request('shipping_city'),
//                    'note' => request('note'),
//                    'name' => request('name'),
//                    'phone' => request('phone'),
//                    'email' => auth()->user()['email'] ?? request('email')
//                ];
//                $data['longitude'] = request('shippingCityLng');
//                $data['latitude'] = request('shippingCityLat');
//            }
//        }

        $delivery_fee = 0;
        $additional_fee = 0;
        if (request('delivery_method') == 'ship') {
            try {
                $weight = 0;
                if ($data['payment_type'] == 'pay_on_delivery')
                    $additional_fee = 0.01 * $cart['total'];
                $data['additional_fee'] = $additional_fee ?? request('additional_fee');
                foreach ($cart['items'] as $item)
                    $weight += $item['product']['weight'] * $item['quantity'];
                $fee = (new DeliveryController)->estimateDeliveryFee($data['region'], $data['town'], $weight)[0];
                $delivery_fee = (float) ($fee ? $fee['TotalAmount'] : request('delivery_fee'));
                $data['delivery_fee'] = $delivery_fee;
            } catch (Exception $e) {
                logger($e);
                return back()->withInput()->with('error', 'Unable to checkout, try again');
            }
        }

        $data['auth'] = !is_null(auth()->user());
        $data['user_id'] = auth()->id();
        $data['delivery_method'] = request('delivery_method');
        $data['cart'] = $cart;
        $data['amount'] = $cart['total'] + $delivery_fee + $additional_fee;

        if (request('payment_type') == 'pay_on_delivery')
            if ($order = PaymentController::finishOrder($data))
                return redirect()->route('orderSuccessful', $order)->with('success', 'Your order was successful');
        return PaymentController::initializeTransaction($data);
    }

    public function estimateDeliveryCost(): bool
    {
        return true;
//        $data = [
//            "customer_name" => "Bar",
//            "customer_phone" => "+2341234567891",
//            "customer_email" => "example+1@about.com",
//            [
//                "address" => request('loc'),
//                "latitude" => request('lat'),
//                "longitude" => request('lng')
//            ]
//        ];
//        return DeliveryController::estimateDelivery($data);
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
        SEOMeta::setTitle('FAQ');
        SEOMeta::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        SEOMeta::setCanonical(route('faq'));

        OpenGraph::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        OpenGraph::setTitle('FAQ');
        OpenGraph::setUrl(route('faq'));
        OpenGraph::addImage(asset('logo/3.png'));

        JsonLd::setTitle('FAQ');
        JsonLd::setDescription(env('APP_NAME').' - Shop smart, buy quality!');
        JsonLd::addImage(asset('logo/3.png'));

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

    /**
     * @throws ValidationException
     */
    public function trackOrder()
    {
        $this->validate(request(), [
            'order_id' => 'required',
            'email' => 'required|email',
        ]);
        $order = Order::query()->where('email', request('email'))->where('code', request('order_id'))->first();
        if (!$order) {
            return back()->with('error', 'We couldn\'t find an order with this ID and email address');
        }
        return view('order-tracker', compact('order'));
    }

    /**
     * @throws ValidationException
     */
    public function updateAccount(): RedirectResponse
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
        User::find(auth()->id())->update($data);
        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function changePassword(): RedirectResponse
    {
        $this->validate(request(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        if (!Hash::check(request('old_password'), auth()->user()['password']))
            return back()->with('error', 'Old password incorrect');
        User::find(auth()->id())->update([
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
        SEOMeta::setTitle($product['name']);
        SEOMeta::setDescription(env('APP_NAME').' - '. $product['description']);
        SEOMeta::setCanonical(route('product.detail', $product['description']));

        OpenGraph::setDescription(env('APP_NAME').' - '. $product['description']);
        OpenGraph::setTitle($product['name']);
        OpenGraph::setUrl(route('product.detail', $product['description']));
        OpenGraph::addImage(asset($product->media()->inRandomOrder()->first()->url ?? null));

        JsonLd::setTitle($product['name']);
        JsonLd::setDescription(env('APP_NAME').' - '. $product['description']);
        JsonLd::addImage(asset($product->media()->inRandomOrder()->first()->url ?? null));

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
        $related = Product::query()->where('is_listed', 1)->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        })->where('id', '!=', $product['id'])->get();
        return view('product-detail', compact('product', 'related'));
    }

    /**
     * @throws ValidationException
     */
    public function storeReview(Product $product): RedirectResponse
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

    public function searchProduct($val): JsonResponse
    {
        $products = Product::query()
            ->where('is_listed', 1)
            ->where(function ($q) use ($val) {
            $q->where('name', 'LIKE', '%'.$val.'%')
                ->orWhere('code', 'LIKE', '%'.$val.'%');
            })->get();
        return response()->json(ProductResource::collection($products));
    }

    public function getInvoice($type, $code)
    {
        if ($type == "sales") $data = Sale::query()->where('code', $code)->first();
        else if ($type == "purchases") $data = Purchase::query()->where('code', $code)->first();
        else throw new NotFoundHttpException;
        if (!$data) throw new NotFoundHttpException;
        $variations = Variation::all();
        return view('invoice', compact('type', 'data', 'variations'));
    }

    /**
     * @throws ValidationException
     */
    public function newsletter(): RedirectResponse
    {
        $this->validate(request(), ['email' => ['required', 'email']]);
        if (!DB::table('newsletter')->where('email', request('email'))->first())
            DB::table('newsletter')->insert(['email' => request('email'), 'created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'You have subscribed for '.env('APP_NAME').' newsletter');
    }

    public static function getAvatar($email): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/$hash?d=".rawurlencode(asset('assets/img/avatar.png'));
    }
}
