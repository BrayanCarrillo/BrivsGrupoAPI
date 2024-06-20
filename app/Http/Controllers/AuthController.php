<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = Staff::where('username', $credentials['username'])->first();

        if (!$user) {
            $admin = Admin::where('username', $credentials['username'])->first();

            if ($admin && $this->validatePassword($credentials['password'], $admin->password)) {
                return response()->json(["role" => "admin"]);
            } else {
                return response()->json(["error" => "Credenciales de inicio de sesión incorrectas"], 401);
            }
        } else {
            // Check if the user is deactivated
            if ($user->status == 0) {
                return response()->json(["error" => "Usuario desactivado"], 403);
            }

            // Si el usuario no tiene un rol entre 'mesero' y 'chef', considerarlo como 'admin'
            $role = strtolower($user->role);
            if (!in_array($role, ['chef', 'mesero'])) {
                return response()->json(["role" => "admin"]);
            } elseif ($role == 'chef') {
                return response()->json(["role" => "chef"]);
            } elseif ($role == 'mesero') {
                return response()->json(["role" => "mesero"]);
            }
        }

        return response()->json(["error" => "Rol de usuario no válido"], 401);
    }

    protected function validatePassword($inputPassword, $hashedPassword)
    {
        // Realiza la validación de contraseñas aquí según tu lógica de comparación
        // En este ejemplo, se realiza una comparación directa, pero puedes adaptarla según tus necesidades y el método de encriptación utilizado
        return $inputPassword === $hashedPassword;
    }

    // Métodos para los dashboards
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
