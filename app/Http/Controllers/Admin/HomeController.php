<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items')->get();
        $purchases = Purchase::with('items')->get();
        $totalSales = 0;
        $totalProfit = 0;
        $totalPurchases = 0;
        $yearPurchases = [];
        $yearSales = [];
        $monthPurchases = [];
        $monthSales = [];
        $yearProfit = [];

        // Compute total sales and profit
        foreach ($sales as $sale) {
            $totalSales += $sale->getSubTotal();
            $totalProfit += $sale->getProfit();
        }

        // Compute total sales
        foreach ($purchases as $purchase) {
            $totalPurchases += $purchase->getSubTotal();
        }

        // Generate current month data
        for ($day = 1; $day <= date('t'); $day++){
            $monthPurchases[] = round(PurchaseItem::query()
                ->whereHas('purchase', function ($q) use($day) {
                    $q->whereDate('date', date('Y-m') . '-' . $day);
                })
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $monthSales[] = round(SaleItem::query()
                ->whereHas('sale', function ($q) use($day) {
                    $q->whereDate('date', date('Y-m') . '-' . $day);
                })
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
        }

        //  Generate current year data
        for ($month = 1; $month <= 12; $month++){
            $yearPurchases[] = round(PurchaseItem::query()
                ->whereHas('purchase', function ($q) use($month) {
                    $q->whereYear('date', date('Y'))
                        ->whereMonth('date', $month);
                })
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $yearSales[] = round(SaleItem::query()
                ->whereHas('sale', function ($q) use($month) {
                    $q->whereYear('date', date('Y'))
                        ->whereMonth('date', $month);
                })
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $yearProfit[] = round(SaleItem::query()
                ->whereHas('sale', function ($q) use($month) {
                    $q->whereYear('date', date('Y'))
                        ->whereMonth('date', $month);
                })
                ->sum('profit'));
        }

        return view('admin.index', [
            'products' => Product::query()->count(),
            'listed_products' => Product::query()->where('is_listed', 1)->count(),
            'admins' => Admin::query()->where('email', '!=', 'softwebdigital@gmail.com')->count(),
            'orders' => Order::query()->count(),
            'sales' => $totalSales,
            'purchases' => $totalPurchases,
            'profit' => $totalProfit,
            'users' => User::query()->count(),
            'suppliers' => Supplier::query()->count(),
            'sales_count' => Sale::query()->count(),
            'purchases_count' => Purchase::query()->count(),
            'top_selling' => Product::with('saleItems')->get()->sortBy(function ($q) { $q->saleItems->count(); })->take(5),
            'chart_data' => [
                'year_transactions' => [
                    'sales' => $yearSales,
                    'purchases' => $yearPurchases,
                    'profit' => $yearProfit
                ],
                'month_transactions' => [
                    'sales' => $monthSales,
                    'purchases' => $monthPurchases
                ]
            ]
        ]);
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function settings()
    {
        try {
            $banks = json_decode(Http::get('https://api.paystack.co/bank'), true)['data'];
        }catch (Exception $exception){
            $banks = [];
        }
        $settings = Setting::query()->first();
        return view('admin.settings', compact('settings', 'banks'));
    }

    /**
     * @throws ValidationException
     */
    public function updateBusiness(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required'],
            'email' => ['required'],
            'phone_1' => ['required'],
            'address' => ['required'],
            'logo' => ['sometimes', 'mimes:jpg,jpeg,png,svg,gif', 'file', 'max:2048'],
            'dashboard_logo' => ['sometimes', 'mimes:jpg,jpeg,png,svg,gif', 'file', 'max:2048'],
        ]);
        $settings = Setting::query()->first();
        if (request('logo')) {
            $path1 = ProductController::saveFileAndReturnPath(request('logo'), Str::random(8));
            if ($settings && $settings['logo']) unlink($settings['logo']);
        }
        if (request('icon')) {
            $icon = ProductController::resizeImageAndReturnPath(request('icon'), Str::random(8), 100, 100, 'img');
            if ($settings && $settings['icon']) unlink($settings['icon']);
        }
        if (request('dashboard_logo')) {
            $path2 = ProductController::saveFileAndReturnPath(request('dashboard_logo'), Str::random(8));
            if ($settings && $settings['dashboard_logo']) unlink($settings['dashboard_logo']);
        }
        if (request('store_logo')) {
            $path3 = ProductController::saveFileAndReturnPath(request('store_logo'), Str::random(8));
            if ($settings && $settings['store_logo']) unlink($settings['store_logo']);
        }
        if (request('email_logo')) {
            $path4 = ProductController::saveFileAndReturnPath(request('email_logo'), Str::random(8));
            if ($settings && $settings['email_logo']) unlink($settings['email_logo']);
        }
        $data = request()->only('name', 'email', 'phone_1', 'phone_2', 'address', 'motto', 'facebook', 'instagram', 'twitter', 'youtube', 'linkedin');
        if (isset($path1)) $data['logo'] = $path1;
        if (isset($icon)) $data['icon'] = $icon;
        if (isset($path2)) $data['dashboard_logo'] = $path2;
        if (isset($path3)) $data['store_logo'] = $path3;
        if (isset($path4)) $data['email_logo'] = $path4;
        if ($settings) $settings->update($data);
        else Setting::query()->create($data);
        return back()->with('success', 'Business profile updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function updateLocations(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'locations' => ['required', 'array', 'min:1']
        ]);
        $settings = Setting::query()->first();
        $data = [];
        foreach (request('locations') as $location) $data[] = array_values($location)[0];
        $settings->update(['pickup_locations' => json_encode($data)]);
        return back()->with('success', 'Bank details updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function updateBank(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'account_name' => ['required'],
            'account_number' => ['required'],
            'bank_name' => ['required']
        ]);
        $data = request()->only('account_name', 'account_number', 'bank_name');
        if ($settings = Setting::query()->first()) $settings->update($data);
        else Setting::query()->create($data);
        return back()->with('success', 'Bank details updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function updateProfile(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'name' => ['required'],
            'phone' => ['required']
        ]);

        Admin::find(auth('admin')->id())->update([
            'name' => request('name'),
            'phone' => request('phone')
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * @throws ValidationException
     */
    public function changePassword(): RedirectResponse
    {
        // Validate request
        $this->validate(request(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8']
        ]);

        if (!Hash::check(request('old_password'), auth()->user()['password'])) {
            return back()->with('error', 'Old password is incorrect');
        }

        Admin::find(auth('admin')->id())->update([
            'password' => Hash::make(request('new_password')),
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    public function sendInvoiceLinkToMail($type, $code): RedirectResponse
    {
        if ($type == "sales") {
            $sale = Sale::query()->where('code', $code)->first();
            $email = $sale['customer_email'];
        }
        else if ($type == "purchases") {
            $purchase = Purchase::query()->where('code', $code)->first();
            $email = $purchase['supplier']['email'];
        }
        else return back()->with('error', 'Invoice type not Supported');
        \App\Http\Controllers\NotificationController::sendInvoiceLinkNotification($email, route('invoice.get', ['type' => $type, 'code' => $code]));
        return back()->with('success', 'Invoice sent successfully');
    }
}
