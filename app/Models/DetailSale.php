<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'stock_id',
        'type_product_id',
        'discount',
        'total',
        'orders',
    ];
}
