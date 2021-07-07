<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Purchase;

class HomeController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items')->get();
        $revenue = 0;
        foreach ($sales as $sale) {
            $revenue += $sales->getTotal();
        }
        return view('admin.index', [
            'revenue' => $revenue,
            'products' => Product::count(),
            'admins' => Admin::count(),
            'orders' => Order::count(),
            'sales' => $revenue,
            'profit' => $revenue,
            'users' => User::count(),
            'suppliers' => Supplier::count(),
            'sales_count' => Sale::count(),
            'puchases_count' => Purchase::count(),
        ]);
    }

    public function analytics()
    {

    }
}
