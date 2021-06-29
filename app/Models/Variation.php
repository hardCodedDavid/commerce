<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VariationItem;

class Variation extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(VariationItem::class);
    }
}
