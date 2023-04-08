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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendInvitation;
use Illuminate\Support\Facades\Mail;

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

    // Envía invitación por correo
    public function send_invitation(Request $request)
    {
        // Validando permiso
        if ( ! Auth::user()->can('send_invitation')){
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        // Validando data
        $validando = \Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'role_id' => 'required|integer',
        ]);

        if ($validando->fails())
        {
            return redirect()->back()->withErrors($validando->errors());
        }

        // Creando usuario y asignando rol
        $password = Str::random(8);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($password),
        ]);
        $user->save();
        $user->assignRole($request->role_id);

        // Enviando credenciales por correo
        $url = env('APP_URL').'/login';
        $data = ['url' => $url, 'email' => $user->email, 'password' => $password];
        Mail::to($user->email)->send(new SendInvitation($data));
        
        return redirect()->back()->with('success', 'La invitación ha sido enviada exitosamente.');
    }
}