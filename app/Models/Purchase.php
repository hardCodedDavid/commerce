<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\PurchaseItem;
use App\Models\Brand;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function brand() 
    {
        return $this->belongsTo(Brand::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function getTotalQuantity()
    {
        return $this->items()->sum('quantity');
    }

    public function getSubTotal()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item['quantity'] * $item['price'];
        }
        return $sum;
    }

    public function getTotal()
    {
        $shipping = $this->shipping_fee ?? 0;
        $additional = $this->additional_fee ?? 0;
        return $this->getSubTotal() + $shipping + $additional;
    }

    public static function getCode()
    {
        $last_item = Purchase::latest()->first();
        if ($last_item) $num = $last_item['id'] + 1;
        else $num = 1;
        return self::generateUniqueCode($num);
    }

    protected static function generateUniqueCode($num)
    {
        while (strlen($num) < 6){
            $num = '0'.$num;
        }
        return 'PS'.$num;
    }
}
