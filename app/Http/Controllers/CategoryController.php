<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\Category as CategoryResources;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = new CategoryCollection( Category::all());

        // return response()->json($categories, 200);
        return Inertia::render('Category/Show', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validando = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['string'],
            'active' => ['boolean'],
        ]);

        $category = new Category($request->all());
        $category->save();
        return redirect()->back()->with('success', 'Regristro creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        if (!$request->category_id) {
            return redirect()->back()->withErrors(['error' => 'El recurso que desea editar, no se encuentra disponible!.']);
        }
        $category = Category::find($request->category_id);
        if ($request->active and $request->active == "Activo") {
            $request->merge(['active' => 1]);
        }
        if ($request->active and $request->active == "Inactivo") {
            $request->merge(['active' => 0]);
        }
        $validando = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
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
    public function destroy(Category $category)
    {
        //
    }
}