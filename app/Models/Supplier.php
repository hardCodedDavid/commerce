<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function getTotalTransactions()
    {
        $total = 0;
        foreach ($this->purchases as $purchase) {
            $total += $purchase->getSubTotal();
        }
        return $total;
    }
}
