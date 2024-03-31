<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class ContrasenaController extends Controller
{
    public function cambiarContrasena(Request $request, $id)
    {
        try {
            // Validar la solicitud y obtener la nueva contraseña del cuerpo de la solicitud
            $request->validate([
                'password' => 'required|string|min:6', // Ajusta las reglas de validación según tus necesidades
            ]);

            // Verificar si el usuario con la ID proporcionada existe
            $empleado = Staff::findOrFail($id);

            // Cambiar la contraseña del empleado
            $nuevaContrasena = Hash::make($request->input('password'));
            $empleado->password = $nuevaContrasena;
            $empleado->save();

            // Devolver una respuesta JSON indicando el éxito
            return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
        } catch (ValidationException $e) {
            // Capturar errores de validación y devolver una respuesta JSON con los errores
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            // Capturar otros errores y devolver una respuesta JSON con un mensaje de error
            return response()->json(['message' => 'Error al cambiar la contraseña'], 500);
        }
    }
}
