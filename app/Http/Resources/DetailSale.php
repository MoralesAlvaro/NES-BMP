<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailSale extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'stock_id' => $this->stock_id,
            'stock_name' => $this->stock,
            'type_product_id' => $this->type_product_id,
            'typeProduct' => $this->typeProduct,
            'discount' => $this->discount,
            'total' => $this->total,
            'orders' => $this->orders,
        ];
    }
}
