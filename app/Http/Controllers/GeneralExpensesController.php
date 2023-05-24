<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General_expense;
use Inertia\Inertia;
use App\Http\Resources\GeneralExpensesCollection;
use Illuminate\Support\Facades\Auth;



class GeneralExpensesController extends Controller
{
    public function index()
    {
        if ( ! Auth::user()->can('expense_list')){//cambiar luego el permiso
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $expenses = new GeneralExpensesCollection( General_expense::orderBy('id', 'desc')->paginate(10));
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('GeneralExpense/Show', [
            'expenses' => $expenses,
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        if ( ! Auth::user()->can('expense_store')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $validando = $request->validate([
            'name' => ['string'],
            'total' => ['string']
        ]);

        $expense = new General_expense($request->all());
        $expense->save();
        return redirect()->back()->with('success', 'Regristro creado correctamente.');
    }

    public function update(Request $request)
    {
        if ( ! Auth::user()->can('expense_update')){
            return redirect()->back()->withErrors(['warning' => '¡No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        if (!$request->expense_id) {
            return redirect()->back()->withErrors(['error' => 'El recurso que desea editar, no se encuentra disponible!.']);
        }
        $category = General_expense::find($request->expense_id);
        /*if ($request->active and $request->active == "Activo") {
            $request->merge(['active' => 1]);
        }
        if ($request->active and $request->active == "Inactivo") {
            $request->merge(['active' => 0]);
        }*/
        $validando = \Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'total' => ['numeric'],
        ]);

        // return response()->json($request->all(), 200);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Registro actualizado correctamente!.');

    }

    public function destroy(Request $request)
    {
        if ( ! Auth::user()->can('expense_destroy')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $expense = General_expense::find($request->id);
        $expense->delete();
        return redirect()->back()->with('success', 'Registro eliminado correctamente!.');

    }

}
