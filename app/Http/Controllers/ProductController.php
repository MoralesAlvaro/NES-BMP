<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Product as ProductResources;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ( ! Auth::user()->can('product_list')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $products = new ProductCollection( Product::orderBy('id', 'desc')->paginate(10));
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('Product/Show', [
            'products' => $products,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can('product_store')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $validando = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'description' => ['string'],
            'active' => ['boolean'],
        ]);

        $product = new Product($request->all());
        $product->save();
        return redirect()->back()->with('success', 'Regristro creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ( ! Auth::user()->can('product_update')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        if (!$request->product_id) {
            return redirect()->back()->withErrors(['error' => 'El recurso que desea editar, no se encuentra disponible!.']);
        }
        $category = Product::find($request->product_id);
        if ($request->active and $request->active == "Activo") {
            $request->merge(['active' => 1]);
        }
        if ($request->active and $request->active == "Inactivo") {
            $request->merge(['active' => 0]);
        }
        $validando = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'description' => ['string'],
            'active' => ['boolean'],
        ]);
        // return response()->json($request->all(), 200);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Registro actualizado correctamente!.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if ( ! Auth::user()->can('product_destroy')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $product = Product::find($request->id);
        $product->delete();
        return redirect()->back()->with('success', 'Registro actualizado correctamente!.');

    }
}