<?php

/**
 * @OA\Info(
 *     title="Título que mostraremos en swagger",
 *     version="1.0",
 *     description="Descripcion"
 * )
 *
 * @OA\Server(url="http://127.0.0.1:8000/api")
 */

/**
 * Título que define lo que hará esta URI
 * @OA\Post (
 *     path="/login",
 *     tags={"Autenticación"},
 *     summary="Iniciar sesión",
 *     description="Inicia sesión con credenciales de usuario",
 *     @OA\Response(
 *         response=200,
 *         description="Iniciar sesión exitoso",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="role",
 *                 type="string",
 *                 example="admin"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Credenciales de inicio de sesión incorrectas",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Credenciales de inicio de sesión incorrectas"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Rol de usuario no válido",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Rol de usuario no válido"
 *             )
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="username",
 *                 type="string",
 *                 example="usuario"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 example="contraseña"
 *             )
 *         )
 *     )
 * )
 */

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
