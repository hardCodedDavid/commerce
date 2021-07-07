<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Brand;
use App\Models\VariationItem;

class SaleItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variationItems()
    {
        return $this->belongsToMany(VariationItem::class);
    }

    public function getVariationItemsIdToArray()
    {
        $arr = [];
        foreach ($this->variationItems()->get() as $item) {
            $arr[] = $item['id'];
        }
        return $arr;
    }
}
