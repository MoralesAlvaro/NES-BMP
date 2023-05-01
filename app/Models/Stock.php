<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $table = 'stock';

    protected $fillable = [
        'product_id',
        'cost',
        'suggested_price',
        'gain'
    ];
    function productname()
    {
        return $this->BelongsTo('ProductName');
    }
}
