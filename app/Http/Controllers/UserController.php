<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\User as UserResources;
use App\Http\Resources\UserCollection;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if ( ! Auth::user()->can('user_index')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $users = new UserCollection(User::all());
        $roles = Role::all();
        //return response()->json($users, 200);
        return Inertia::render('User/Show',[
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
