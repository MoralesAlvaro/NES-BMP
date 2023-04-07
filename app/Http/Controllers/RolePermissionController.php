<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    public function index()
    {

        /* if ( ! Auth::user()->can('permission_index')){
            return redirect()->back()->with('warning', 'No posees los permisos necesarios. Ponte en contacto con tu manager!.');
        } */

        $roles = Role::all();
        //return response()->json($roles, 200);
        return Inertia::render('Roles/Show',[
            'roles' => $roles,
        ]);
    }
}
