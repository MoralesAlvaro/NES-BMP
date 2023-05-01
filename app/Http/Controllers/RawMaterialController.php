<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\Product;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use Inertia\Inertia;
use App\Http\Resources\RawMaterial as RawMaterialResources;
use App\Http\Resources\RawMaterialCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( ! Auth::user()->can('rawMaterial_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $reawMaterials = new RawMaterialCollection( RawMaterial::orderBy('id', 'desc')->paginate(5));
        $products = Product::all();
        $permissions = Auth::user()->getAllPermissions();

        // return response()->json($permissions, 200);
        return Inertia::render('RawMaterial/Show', [
            'reawMaterials' => $reawMaterials,
            'products' => $products,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can('rawMaterial_store')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $validando = $request->validate([
            'product_id' => ['required', 'integer'],
            'total' => ['required'],
            'quantity' => ['required', 'string', 'max:255'],
            'parts' => ['required', 'integer', 'min:1'],
            'cost' => ['required'],
            'active' => ['required', 'boolean'],
        ]);

        try {
            $reawMaterial = new RawMaterial($request->all());
            $reawMaterial->save();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => 'Ops! Ha ocurrido un error']);
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
        //
    }
}
