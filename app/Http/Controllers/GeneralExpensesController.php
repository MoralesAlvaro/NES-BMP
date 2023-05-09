<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General_expense;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GeneralExpensesCollection;



class GeneralExpensesController extends Controller
{


    public function index()
    {
        if ( ! Auth::user()->can('product_list')){//cambiar luego el permiso
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $products = new GeneralExpensesCollection( General_expense::orderBy('id', 'desc')->paginate(10));
        $permissions = Auth::user()->getAllPermissions();
        //return response()->json($products, 200);
        return Inertia::render('Product/Show', [//se acopla  la vista product, suguiero copiar los metodos XD
            'products' => $products,
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        if ( ! Auth::user()->can('product_store')){//cambiar permisos luego
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $validando = $request->validate([
            'name' => ['string'],
            'total' => ['decimal']
        ]);

        $expense = new General_expense($request->all());
        $expense->save();
        return redirect()->back()->with('success', 'Regristro creado correctamente.');
    }


}
