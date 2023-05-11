<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SaleDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class Sale extends JsonResource
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
            'status_sale_id' => $this->status_sale_id === 1? false : true,
            'user' => $this->user,
            'type_doc_id' => $this->typeDoc,
            'sup_total' => $this->sup_total,
            'discount' => $this->discount,
            'total' => $this->total,
            'detailSale' => $this->detailSale,
            'created' => $this->created_at->diffForHumans(),
            'updated' => $this->updated_at->diffForHumans(),
            'created_at' => $this->created_at->format('d-m-y'),
            'updated_at' => $this->updated_at->format('d-m-y'),
        ];
    }
}
