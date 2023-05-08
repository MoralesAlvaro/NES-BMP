<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StatusSale;
use App\Models\TypeDoc;
use App\Models\stock;
use App\Models\DetailSale;
use App\Models\TypeProduct;
use Illuminate\Support\Facades\DB;
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
        // return response()->json($request->detail_sale[0], 200);
        if (count($request->detail_sale) < 1) {
            return redirect()->back()->withErrors(['warning' => 'Agrega el detalle de venta por favor.']);
        }
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

        $request->merge(['sale_id' => $sale->id]);


        foreach ($request->detail_sale as $key) {
            DetailSale::insert([
                'sale_id' => $sale->id,
                'stock_id' => $key['stock_id'],
                'type_product_id' => $key['type_product_id'],
                'discount' => $key['discount'],
                'total' => $key['total'],
                'orders' => $key['orders'],
            ]);
        }

        return redirect()->back()->with('success', 'Registro creado correctamente!.');


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
    public function destroy(Request $request)
    {
        if ( ! Auth::user()->can('sale_destroy')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $detail = DetailSale::where('sale_id', $request->id)->delete();

        $sale = Sale::find($request->id);
        $sale->delete();
        return redirect()->back()->with('success', 'Registro eliminado correctamente!.');

    }
}
