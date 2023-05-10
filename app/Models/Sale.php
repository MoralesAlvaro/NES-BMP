<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        return $this->belongsTo(StatusSale::class);
    }

    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
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
