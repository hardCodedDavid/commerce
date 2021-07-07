<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\VariationItem;
use App\Models\Media;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function variationItems()
    {
        return $this->belongsToMany(VariationItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function getProfit()
    {
        return $this['sell_price'] - $this['buy_price'];
    }

    public static function getCode()
    {
        $last_item = Product::latest()->first();
        if ($last_item) $num = $last_item['id'] + 1;
        else $num = 1;
        return self::generateUniqueCode($num);
    }

    protected static function generateUniqueCode($num)
    {
        while (strlen($num) < 6){
            $num = '0'.$num;
        }
        return 'PD'.$num;
    }
}
