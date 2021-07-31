<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'code' => $this['code'],
            'name' => ucwords($this['name']),
            'weight' => $this['weight'],
            'price' => $this->getDiscountedPrice(),
            'actualPrice' => $this['sell_price'],
            'inStock' => $this['in_stock'] == 1,
            'media' => $this->media()->get()->map(function ($item) {
                            return asset($item['url']);
                       })
        ];
    }
}
