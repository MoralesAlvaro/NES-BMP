<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'raw_material_id',
        'name',
        'cost',
        'mount',
        'gain',
        'active'
    ];

    public function rawMaterial()
    {
        return $this->belongsTo(rawMaterial::class);

    }
}
