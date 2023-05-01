<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\StockCollection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;





class StockController extends Controller
{

    public function index()
    {
        /*if ( ! Auth::user()->can('stock_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }*/

        $stock = new StockCollection(Stock::join('product','stock.product_id','=','product.id')->select('stock.id','product.name','product.measure','stock.cost','stock.suggested_price','stock.gain')->orderBy('id','desc')->paginate(10));
        #return $stock;
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('Stock/Show', [
            'stocks' => $stock,
            'permissions' => $permissions
        ]);
    }
}
