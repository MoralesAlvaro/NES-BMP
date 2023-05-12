<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductName extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'name',
        'measure'
    ];

    function stock()
    {
        return $this->hasMany('stock');
    }
}
