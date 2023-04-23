<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use Inertia\Inertia;
use App\Http\Resources\RawMaterial as RawMaterialResources;
use App\Http\Resources\RawMaterialCollection;
use Illuminate\Support\Facades\Auth;

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
        $permissions = Auth::user()->getAllPermissions();

        // return response()->json($permissions, 200);
        return Inertia::render('RawMaterial/Show', [
            'reawMaterials' => $reawMaterials,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRawMaterialRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        //
    }
}
