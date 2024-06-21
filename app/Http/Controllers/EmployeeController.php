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
            // Convertir el rol a la forma correcta
            $roleValue = ucfirst(strtolower($request->input('role')));
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
        
        // Convertir el valor del frontend a la forma correcta para el backend
        $roleValue = ucfirst(strtolower($request->input('role')));
        $empleado->role = $roleValue;

        // Asignar un valor temporal al campo password
        $empleado->password = bcrypt('password');

        $empleado->save();

        return response()->json($empleado, 201);
    }

    // Actualizar estado del empleado sin cambiar la ruta de eliminar empleado
    public function actualizarEstadoEmpleado(Request $request, $id)
    {
        $empleado = Staff::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        // Verificar y actualizar el estado si se proporciona en la solicitud
        if ($request->has('status')) {
            // Convertir el estado a la forma correcta
            $statusValue = (bool)$request->input('status');
            $empleado->status = $statusValue;
            $empleado->save();

            return response()->json(['message' => 'Estado del empleado actualizado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Estado no proporcionado en la solicitud'], 400);
        }
    }

    // Actualizar nombre del empleado
    public function actualizarNombreEmpleado(Request $request, $id)
    {
        $empleado = Staff::find($id);
        if (!$empleado) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }

        // Verificar y actualizar el nombre si se proporciona en la solicitud
        if ($request->has('username')) {
            $empleado->username = $request->input('username');
            $empleado->save();

            return response()->json(['message' => 'Nombre del empleado actualizado correctamente'], 200);
        } else {
            return response()->json(['message' => 'Nombre no proporcionado en la solicitud'], 400);
        }
    }
}
