<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Stock extends JsonResource
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
            'raw_material_id' => $this->rawMaterial->id,
            'raw_material' => $this->rawMaterial,
            'product' => $this->rawMaterial->product,
            'name' => $this->name,
            'mount' => $this->mount,
            'gain' => $this->gain,
            'cost' => $this->cost,
            'active' => $this->active ? 'Activo' : 'Inactivo',
            'created' => $this->created_at->diffForHumans(),
            'updated' => $this->updated_at->diffForHumans(),
            'created_at' => $this->created_at->format('d-m-y'),
            'updated_at' => $this->updated_at->format('d-m-y'),
        ];
    }
}
