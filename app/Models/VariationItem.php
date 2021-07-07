<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use App\Models\OrderItem;

class VariationItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function purchaseItems()
    {
        return $this->belongsToMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->belongsToMany(SaleItem::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class);
    }
}