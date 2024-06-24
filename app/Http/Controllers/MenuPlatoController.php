<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuPlatoController extends Controller
{
    // Obtener todos los platos con el nombre del menú
    public function obtenerPlatos()
    {
        // Cargar la relación del menú usando 'with'
        $platos = MenuItem::with('menu')->get();
        
        // Mapear la respuesta para incluir el nombre del menú en lugar del menuID
        $platosConMenu = $platos->map(function ($plato) {
            return [
                'itemID' => $plato->itemID,
                'menu' => $plato->menu ? $plato->menu->menuName : null,
                'menuItemName' => $plato->menuItemName,
                'price' => $plato->price,
            ];
        });

        return response()->json($platosConMenu, 200);
    }

    // Editar plato con posibilidad de cambiar menuID
    public function editarPlato(Request $request, $itemID)
    {
        $plato = MenuItem::find($itemID);
        if (!$plato) {
            return response()->json(['message' => 'Plato no encontrado'], 404);
        }

        // Actualiza los datos del plato, incluido menuID si se proporciona en la solicitud
        $plato->menuItemName = $request->input('menuItemName', $plato->menuItemName);
        $plato->price = $request->input('price', $plato->price);
        $plato->menuID = $request->input('menuID', $plato->menuID);
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
 // Agregar plato
public function agregarPlato(Request $request)
{
    $plato = new MenuItem();
    $plato->menuItemName = $request->input('menuItemName');
    $plato->price = $request->input('price');
    $plato->menuID = $request->input('menuID'); // Asegúrate de que esta línea sea necesaria según tu lógica de negocio
    $plato->activate = $request->input('activate', true); // Asegúrate de incluir activate
    $plato->save();

    return response()->json($plato, 201);
}


    // Obtener platos por categoría
public function obtenerPlatosPorCategoria($menuID)
{
    $platos = MenuItem::with('menu')->where('menuID', $menuID)->get();
    
    $platosConMenu = $platos->map(function ($plato) {
        return [
            'itemID' => $plato->itemID,
            'menu' => $plato->menu ? $plato->menu->menuName : null,
            'menuItemName' => $plato->menuItemName,
            'price' => $plato->price,
        ];
    });

    return response()->json($platosConMenu, 200);
}

public function cambiarEstadoPlato(Request $request, $itemID)
{
    $plato = MenuItem::find($itemID);
    
    if (!$plato) {
        return response()->json(['message' => 'Plato no encontrado'], 404);
    }

    // Cambiar el estado del plato
    $plato->activate = $request->input('activate', $plato->activate);
    $plato->save();

    return response()->json($plato, 200);
}
}
