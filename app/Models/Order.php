<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
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
        $shipping = $this->shipping ?? 0;
        return $this->getSubTotal() + $shipping;
    }

    public static function getCode()
    {
        $last_item = Order::latest()->first();
        if ($last_item) $num = $last_item['id'] + 1;
        else $num = 1;
        return self::generateUniqueCode($num);
    }

    protected static function generateUniqueCode($num)
    {
        while (strlen($num) < 6){
            $num = '0'.$num;
        }
        return 'SL'.$num;
    }
}
