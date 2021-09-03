<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['media', 'categories', 'subcategories', 'reviews'];

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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getProfit()
    {
        return $this['sell_price'] - $this['buy_price'];
    }

    public static function getCode()
    {
        $last_item = static::latest()->first();
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

    public function getFormattedActualPrice()
    {
        return number_format($this->sell_price);
    }

    public function getFormattedDiscountedPrice()
    {
        return number_format($this->sell_price - $this->discount);
    }

    public function getDiscountedPrice()
    {
        return $this->sell_price - $this->discount;
    }

    public function getDiscountedPercent()
    {
        return round((($this->discount) / $this->sell_price) * 100);
    }

    public function isDiscounted()
    {
        return ($this->discount && $this->discount > 0);
    }

    public function isNew()
    {
        return Carbon::parse($this->created_at)->addDays(30)->gt(now());
    }
}
