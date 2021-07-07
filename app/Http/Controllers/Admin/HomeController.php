<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\SaleItem;

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
        $salesYear = [];

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
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $monthSales[] = round(SaleItem::query()
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
        }

        //  Generate current year data
        for ($month = 1; $month <= 12; $month++){
            $yearPurchases[] = round(PurchaseItem::query()
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $yearSales[] = round(SaleItem::query()
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->select(DB::raw('sum(price * quantity) as total'))->first()['total']);
            $yearProfit[] = round(SaleItem::query()
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $month)
                ->sum('profit'));
        }

        return view('admin.index', [
            'products' => Product::count(),
            'listed_products' => Product::where('is_listed', 1)->count(),
            'admins' => Admin::count(),
            'orders' => Order::count(),
            'sales' => $totalSales,
            'purchases' => $totalPurchases,
            'profit' => $totalProfit,
            'users' => User::count(),
            'suppliers' => Supplier::count(),
            'sales_count' => Sale::count(),
            'puchases_count' => Purchase::count(),
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

    public function analytics()
    {

    }
}
