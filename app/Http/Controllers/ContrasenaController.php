<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class ContrasenaController extends Controller
{
    public function cambiarContrasena(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $empleado = Staff::find($id);

        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        // Actualizar la contraseña del empleado
        $empleado->password = Hash::make($request->input('password'));
        $empleado->save();

        return response()->json(['message' => 'Contraseña cambiada correctamente'], 200);
    }
}
