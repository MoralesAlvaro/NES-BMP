<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StatusSale;
use App\Models\TypeDoc;
use App\Models\stock;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Sale as SaleResources;
use App\Http\Resources\SaleCollection;
use App\Http\Resources\Stock as StockResources;
use App\Http\Resources\StockCollection;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( ! Auth::user()->can('sale_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $sales = new SaleCollection( Sale::orderBy('id', 'desc')->paginate(10));
        $typeDoc = TypeDoc::all();
        $statusSale = StatusSale::all();
        $stocks = new StockCollection( Stock::orderBy('id', 'desc')->get());
        $typeProduct = TypeProduct::all();
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('Sale/Show', [
            'sales' => $sales,
            'typeDoc' => $typeDoc,
            'statusSale' => $statusSale,
            'stocks' => $stocks,
            'typeProduct' => $typeProduct,
            'permissions' => $permissions
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can('sale_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $request->merge(['status_sale_id' => 1, 'user_id' => Auth::user()->id, 'type_doc_id' => 1]);
        // return response()->json($request->all(), 200);
        $validando = $request->validate([
            'status_sale_id' => ['integer'],
            'user_id' => ['integer'],
            'type_doc_id' => ['integer'],
            'sup_total' => ['numeric'],
            'discount' => ['numeric'],
            'total' => ['numeric'],
        ]);

        $sale = new Sale($request->all());
        $sale->save();
        // return response()->json($request, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
