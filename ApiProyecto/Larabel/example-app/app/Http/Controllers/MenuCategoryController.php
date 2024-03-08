<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuCategoryController extends Controller
{
    // Método para obtener todas las categorías de menú
    public function index()
    {
        $categorias = Menu::all();
        return response()->json($categorias);
    }

    // Método para mostrar una categoría de menú específica
    public function show($id)
    {
        $categoria = Menu::find($id);
        if (!$categoria) {
            return response()->json(['error' => 'Categoría de menú no encontrada'], 404);
        }
        return response()->json($categoria);
    }

    // Método para crear una nueva categoría de menú
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:tbl_menu,menuName',
        ]);

        $categoria = new Menu();
        $categoria->menuName = $request->nombre;
        $categoria->save();

        return response()->json($categoria, 201);
    }

    // Método para actualizar una categoría de menú existente
    public function update(Request $request, $id)
    {
        $categoria = Menu::find($id);
        if (!$categoria) {
            return response()->json(['error' => 'Categoría de menú no encontrada'], 404);
        }

        $categoria->menuName = $request->nombre;
        $categoria->save();

        return response()->json($categoria);
    }

    // Método para eliminar una categoría de menú
    public function destroy($id)
    {
        $categoria = Menu::find($id);
        if (!$categoria) {
            return response()->json(['error' => 'Categoría de menú no encontrada'], 404);
        }
        $categoria->delete();

        return response()->json(['message' => 'Categoría de menú eliminada']);
    }
}
