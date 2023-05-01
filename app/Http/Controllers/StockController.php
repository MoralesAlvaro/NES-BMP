<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Product as StockResources;
use App\Http\Resources\StockCollection;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( ! Auth::user()->can('stock_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $stocks = new StockCollection( Stock::orderBy('id', 'desc')->paginate(10));
        $raw_materials = RawMaterial::all();
        $permissions = Auth::user()->getAllPermissions();
        return response()->json(['stocks' => $stocks, 'raw_materials' => $raw_materials, 'permissions' => $permissions], 200); // Eliminar esta lína cuando se agrege la vista

        return Inertia::render('Stock/Show', [
            'stocks' => $stocks,
            'raw_materials' => $raw_materials,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
