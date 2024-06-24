<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;

class MesaController extends Controller
{
    // Método para obtener todas las mesas
    public function index()
    {
        $mesas = Mesa::all();
        return response()->json($mesas);
    }

    // Método para mostrar una mesa específica
    public function show($id)
    {
        $mesa = Mesa::find($id);
        if (!$mesa) {
            return response()->json(['error' => 'Mesa not found'], 404);
        }
        return response()->json($mesa);
    }

    // Método para crear una nueva mesa
    public function store(Request $request)
    {
        $request->validate([
            'mesaID' => 'required|integer', // Cambiado a mesaID y se espera un entero
            'activate' => 'required|boolean', // Se espera un valor booleano para activate
        ]);

        $mesa = new Mesa();
        $mesa->mesaID = $request->input('mesaID'); // Ajuste para usar mesaID
        $mesa->activate = $request->input('activate'); // Ajuste para usar activate
        $mesa->save();

        return response()->json($mesa, 201);
    }

    // Método para actualizar una mesa existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'mesaID' => 'required|integer', // Cambiado a mesaID y se espera un entero
            'activate' => 'required|boolean', // Se espera un valor booleano para activate
        ]);

        $mesa = Mesa::find($id);
        if (!$mesa) {
            return response()->json(['error' => 'Mesa not found'], 404);
        }

        $mesa->mesaID = $request->input('mesaID'); // Ajuste para usar mesaID
        $mesa->activate = $request->input('activate'); // Ajuste para usar activate
        $mesa->save();

        return response()->json($mesa);
    }

    // Método para eliminar una mesa
    public function destroy($id)
    {
        $mesa = Mesa::find($id);
        if (!$mesa) {
            return response()->json(['error' => 'Mesa not found'], 404);
        }
        $mesa->delete();

        return response()->json(['message' => 'Mesa deleted']);
    }
    
    // Método para cambiar el estado de una mesa (activar/desactivar)
    public function cambiarEstadoMesa(Request $request, $id)
    {
        $request->validate([
            'activate' => 'required|boolean', // Se espera un valor booleano para activate
        ]);

        $mesa = Mesa::find($id);
        if (!$mesa) {
            return response()->json(['error' => 'Mesa not found'], 404);
        }

        $mesa->activate = $request->input('activate'); // Actualiza el estado de la mesa
        $mesa->save();

        return response()->json($mesa);
    }
}
