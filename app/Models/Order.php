<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function activities()
    {
        return $this->hasMany(OrderActivity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
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

    public static function getCode(): int
    {
        do {
            $key = mt_rand(1000000, 9999999);
        } while (static::query()->where('code', $key)->count() > 0);
        return $key;
    }
}
