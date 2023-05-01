<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'total',
        'quantity',
        'parts',
        'cost',
        'active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
