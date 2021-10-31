<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(OrderActivity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sale(): HasOne
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
        foreach ($this->items()->get() as $item)
            $sum += $item['quantity'] * $item['price'];

        return $sum;
    }

    public function getTotal()
    {
        $shipping = $this->shipping ?? 0;
        $additional_fee = $this->additional_fee ?? 0;
        return $this->getSubTotal() + $shipping + $additional_fee;
    }

    public static function getCode(): int
    {
        do {
            $key = mt_rand(1000000, 9999999);
        } while (static::query()->where('code', $key)->count() > 0);
        return $key;
    }
}
