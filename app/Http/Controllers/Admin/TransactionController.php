<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function purchases()
    {
        return view('admin.transactions.purchases.index');
    }

    public function sales()
    {
        return view('admin.transactions.sales.index');
    }

    public function createPurchase()
    {
        return view('admin.transactions.purchases.create');
    }

    public function createSale()
    {
        return view('admin.transactions.sales.create');
    }

    public function showPurchase()
    {
        return view('admin.transactions.purchases.show');
    }

    public function showSale()
    {
        return view('admin.transactions.sales.show');
    }
}
