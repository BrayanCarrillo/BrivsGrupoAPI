<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuPlatoController extends Controller
{
    // Editar plato
    public function editarPlato(Request $request, $itemID)
    {
        $plato = MenuItem::find($itemID);
        if (!$plato) {
            return response()->json(['message' => 'Plato no encontrado'], 404);
        }

        // Actualiza los datos del plato
        $plato->menuItemName = $request->input('menuItemName');
        $plato->price = $request->input('price');
        $plato->save();

        return response()->json($plato, 200);
    }

    // Eliminar plato
    public function eliminarPlato($itemID)
    {
        $plato = MenuItem::find($itemID);
        if (!$plato) {
            return response()->json(['message' => 'Plato no encontrado'], 404);
        }

        $plato->delete();

        return response()->json(['message' => 'Plato eliminado'], 200);
    }

    // Agregar plato
    public function agregarPlato(Request $request)
    {
        $plato = new MenuItem();
        $plato->menuItemName = $request->input('menuItemName');
        $plato->price = $request->input('price');
        $plato->menuID = $request->input('menuID'); // Asegúrate de que esta línea sea necesaria según tu lógica de negocio
        $plato->save();

        return response()->json($plato, 201);
    }
}
