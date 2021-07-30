<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function updateTotal()
    {
        $sum = 0;
        foreach ($this->items()->get() as $item) {
            $sum += ($item['product']['sell_price'] - $item['product']['discount']) * $item['quantity'];
        }
        $this->update([
            'total' => $sum
        ]);
    }
}
