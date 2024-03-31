<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class EmployeeController extends Controller
{
    // Lista de todos los empleados
    public function listarEmpleados()
    {
        $empleados = Staff::select('staffID', 'username', 'status', 'role')->get();
        return response()->json(['empleados' => $empleados]);
    }

    // Eliminar empleado con una ID específica
    public function eliminarEmpleado($id)
    {
        $empleado = Staff::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado'], 200);
    }

    // Actualizar rol del empleado
    public function actualizarRolEmpleado(Request $request, $id)
    {
        $empleado = Staff::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        // Verificar y actualizar el rol si se proporciona en la solicitud
        if ($request->has('role')) {
            $roleValue = strtolower($request->input('role')); // Convertir a minúsculas
            $empleado->role = $roleValue;
            $empleado->save();

            return response()->json(['message' => 'Rol actualizado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Rol no proporcionado en la solicitud'], 400);
        }
    }

    // Agregar empleado
    public function agregarEmpleado(Request $request)
    {
        $empleado = new Staff();
        $empleado->username = $request->input('username');
        $empleado->status = $request->input('status');
        
        // Convertir el valor del frontend a minúsculas para el backend
        $roleValue = strtolower($request->input('role')); // Convertir a minúsculas
        $empleado->role = $roleValue;

        // Asignar un valor temporal al campo password
        $empleado->password = bcrypt('password');

        $empleado->save();

        return response()->json($empleado, 201);
    }
}
