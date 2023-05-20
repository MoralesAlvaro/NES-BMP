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
        if ( ! Auth::user()->can('user_list')){
            return redirect()->back()->withErrors(['warning' => '¡No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        $users = new UserCollection(User::where('active', 1)->orderBy('id', 'desc')->get());
        $roles = Role::where('id', '<>', 1)->get();
        $permissions = Auth::user()->getAllPermissions();

        //return response()->json($permissions, 200);
        return Inertia::render('User/Show',[
            'users' => $users,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    // Envía invitación por correo
    public function send_invitation(Request $request)
    {
        // Validando permiso
        if ( ! Auth::user()->can('send_invitation')){
            return redirect()->back()->withErrors(['warning' => '¡No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        // Validando data
        $validando = \Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'role_id' => 'required|integer',
            'telephone' => 'nullable|integer',
        ]);

        if ($validando->fails())
        {
            return redirect()->back()->withErrors($validando->errors());
        }

        // Creando usuario y asignando rol
        $password = Str::random(12);
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'telephone' => $request->get('telephone'),
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

    public function change_role(Request $request)
    {
        // Validando permiso
        if ( ! Auth::user()->can('change_role')){
            return redirect()->back()->withErrors(['error' => 'No posees los permisos necesarios. Ponte en contacto con manager!.']);
        }
        // Validando el id del rol
        if ($request->get('role_id') != '' or $request->get('role_id') != null) {
            // Validando el recurso solicitado
            $rol = Role::find($request->get('role_id'));
            if (!isset($rol)) {
                return redirect()->back()->withErrors(['error' => 'Rol no válido!.']);
            }

            // Validando el usuario
            if ($request->get('user_id') != '' or $request->get('user_id') != null) {
                // Validando recurso solicitado
                $user = User::find($request->get('user_id'));
                if (!isset($user)) {
                    return redirect()->back()->withErrors(['error' => 'Usuario no válido!.']);
                }

                // Verificando si el usuario tenia rol asignado
                if (!empty($user->roles[0]->name)) {
                    // Revocando rol
                    $user->removeRole($user->roles[0]->name);
                }
                $user->assignRole($rol->name);
                return redirect()->back()->with('success', 'Registro actualizado correctamente!.');

            }else{
                return redirect()->back()->withErros(['error' => 'Debes indicar el usuario al que deseas cambiar el rol!.']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Debes indicar el rol a asignar!.']);
        }
    }

    public function destroy(User $user)
    {
        if ( ! Auth::user()->can('user_destroy')){
            return redirect()->back()->withErrors(['warning' => '¡No posees los permisos necesarios. Ponte en contacto con tu manager!.']);
        }

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'Usuario no ha sido encontrado.']);
        }

        $user->active = false;
        $user->update();
        return redirect()->back()->with('success', 'Registro eliminado correctamente!.');
    }
}
