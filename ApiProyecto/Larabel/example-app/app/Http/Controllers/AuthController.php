<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Lógica de autenticación
        $user = Staff::where('username', $credentials['username'])->first();

        if (!$user) {
            $admin = Admin::where('username', $credentials['username'])->first();

            if ($admin && $admin->password == $credentials['password']) {
                return redirect()->route('admin_dashboard');
            } else {
                return response()->json(["error" => "Credenciales de inicio de sesión incorrectas"], 401);
            }
        } else {
            $role = strtolower($user->role);
            if ($role == 'chef') {
                return redirect()->route('chef_dashboard');
            } elseif ($role == 'mesero') {
                return redirect()->route('mesero_dashboard');
            } else {
                return response()->json(["error" => "Rol de usuario no válido"], 401);
            }
        }
    }

    public function adminDashboard()
    {
        return response()->json(["message" => "Bienvenido al panel de control del administrador"]);
    }

    public function chefDashboard()
    {
        return response()->json(["message" => "Bienvenido al panel de control del chef"]);
    }

    public function meseroDashboard()
    {
        return response()->json(["message" => "Bienvenido al panel de control del mesero"]);
    }
}
