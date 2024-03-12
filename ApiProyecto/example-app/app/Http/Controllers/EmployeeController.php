<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff; // Cambiado de User a Staff

class EmployeeController extends Controller
{
    // Lista de todos los empleados
    public function listarEmpleados()
    {
        $empleados = Staff::select('staffID', 'username', 'status', 'role')->get(); // Cambiado de 'id' a 'staffID', 'name' a 'username', 'estado' a 'status', 'rol' a 'role'
        return response()->json(['empleados' => $empleados]);
    }

    // Eliminar empleado con una ID específica
    public function eliminarEmpleado($id)
    {
        $empleado = Staff::find($id); // Cambiado de User a Staff
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado'], 200);
    }

    // Actualizar empleado
    public function actualizarEmpleado(Request $request, $id)
    {
        $empleado = Staff::find($id); // Cambiado de User a Staff
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        $empleado->username = $request->input('username'); // Cambiado de 'name' a 'username'
        $empleado->status = $request->input('status'); // Cambiado de 'estado' a 'status'
        $empleado->role = $request->input('role'); // Cambiado de 'rol' a 'role'
        $empleado->save();

        return response()->json($empleado, 200);
    }

    // Agregar empleado
    public function agregarEmpleado(Request $request)
    {
        $empleado = new Staff(); // Cambiado de User a Staff
        $empleado->username = $request->input('username'); // Cambiado de 'name' a 'username'
        $empleado->status = $request->input('status'); // Cambiado de 'estado' a 'status'
        $empleado->role = $request->input('role'); // Cambiado de 'rol' a 'role'
        $empleado->save();

        return response()->json($empleado, 201);
    }
}
