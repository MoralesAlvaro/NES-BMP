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
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $stocks = new StockCollection( Stock::orderBy('id', 'desc')->paginate(10));
        $raw_materials = RawMaterial::all();
        $permissions = Auth::user()->getAllPermissions();

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
        if ( ! Auth::user()->can('stock_update')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        if (!$request->stock_id) {
            return redirect()->back()->withErrors(['error' => 'El recurso que desea editar, no se encuentra disponible!.']);
        }

        $stock = Stock::find($request->stock_id);
        if ($request->active and $request->active == "Activo") {
            $request->merge(['active' => 1]);
        }
        if ($request->active and $request->active == "Inactivo") {
            $request->merge(['active' => 0]);
        }

        $validando = \Validator::make($request->all(), [
            'raw_material_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'cost' => ['required'],
            'mount' => ['required'],
            'gain' => ['required'],
            'active' => ['boolean'],
        ]);
        // return response()->json($request->all(), 200);

        $stock->update($request->all());

        return redirect()->back()->with('success', 'Registro actualizado correctamente!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ( ! Auth::user()->can('stock_destroy')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $stock = Stock::find($request->id);
        $stock->delete();
        return redirect()->back()->with('success', 'Registro eliminado correctamente!.');
    }
}
