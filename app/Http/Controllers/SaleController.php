<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\StatusSale;
use App\Models\TypeDoc;
use App\Models\stock;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Sale as SaleResources;
use App\Http\Resources\SaleCollection;
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
        $stocks = Stock::all();
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('Sale/Show', [
            'sales' => $sales,
            'typeDoc' => $typeDoc,
            'statusSale' => $statusSale,
            'stocks' => $stocks,
            'permissions' => $permissions
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesRequest $request, Sales $sales)
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
