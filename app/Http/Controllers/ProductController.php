<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Product as ProductResources;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = new ProductCollection( Product::all());

        return Inertia::render('Product/Show', [
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validando = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
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
    public function update(Request $request, Product $product)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
