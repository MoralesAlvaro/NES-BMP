<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_sale_id',
        'user_id',
        'type_doc_id',
        'sup_total',
        'discount',
        'total',
    ];

    public function statusSale()
    {
        return $this->belongsTo(StatuSale::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function typeDoc()
    {
        return $this->belongsTo(TypeDoc::class);
    }
}
