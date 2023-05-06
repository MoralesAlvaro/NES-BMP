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
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
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
            $rawMaterial = new RawMaterial($request->all());
            $rawMaterial->save();
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
        if ( ! Auth::user()->can('rawMaterial_update')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        if (!$request->rawMaterial_id) {
            return redirect()->back()->withErrors(['error' => 'El recurso que desea editar, no se encuentra disponible!.']);
        }

        $rawMaterial = RawMaterial::find($request->rawMaterial_id);
        if ($request->active and $request->active == "Activo") {
            $request->merge(['active' => 1]);
        }

        if ($request->active and $request->active == "Inactivo") {
            $request->merge(['active' => 0]);
        }

        $validando = $request->validate([
            'product_id' => ['required', 'integer'],
            'total' => ['required'],
            'quantity' => ['required', 'string', 'max:255'],
            'parts' => ['required', 'integer', 'min:1'],
            'cost' => ['required'],
            'active' => ['required', 'boolean'],
        ]);

        // return response()->json($request->all(), 200);
        $rawMaterial->update($request->all());

        return redirect()->back()->with('success', 'Registro actualizado correctamente!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ( ! Auth::user()->can('rawMaterial_destroy')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $rawMaterial = RawMaterial::find($request->id);
        $rawMaterial->delete();
        return redirect()->back()->with('success', 'Registro eliminado correctamente!.');
    }
}
