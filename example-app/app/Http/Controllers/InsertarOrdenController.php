<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MenuItem;
use App\Models\Menu; // Importar la clase Menu
use App\Models\Mesa;
class InsertarOrdenController extends Controller
{

    public function obtenerCategoriasPlatos()
    {
        try {
            // Obtener todas las categorías de menú con sus platos relacionados
            $categoriasPlatos = Menu::with('items')->get(); // Utilizar la clase Menu

            return response()->json(['categorias' => $categoriasPlatos], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las categorías y platos: ' . $e->getMessage()], 500);
        }
    }
    
    public function insertarOrden(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'mesaID' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.itemID' => 'required|integer|exists:tbl_menuitem,itemID',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.menuID' => 'required|integer|exists:tbl_menu,menuID',
        ]);

        try {
            // Crear una nueva orden
            $order = new Order();
            $order->mesaID = $request->input('mesaID');
            $order->status = 'esperando'; // Estado por defecto
            $order->order_date = now(); // Fecha actual
            $order->total = 0; // Inicializar el total en 0
            $order->save();

            // Calcular el total de la orden
            $totalOrder = 0;

            // Agregar los detalles de la orden (ítems)
            foreach ($request->input('items') as $item) {
                // Obtener el ítem de menú y validar que pertenezca al menú especificado
                $menuItem = MenuItem::where('itemID', $item['itemID'])
                    ->where('menuID', $item['menuID'])
                    ->first();

                if ($menuItem) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->orderID = $order->orderID;
                    $orderDetail->itemID = $menuItem->itemID;
                    $orderDetail->quantity = $item['quantity'];
                    $orderDetail->save();

                    // Sumar el subtotal al total de la orden
                    $totalOrder += $menuItem->price * $item['quantity'];
                }
            }

            // Actualizar el total de la orden con el cálculo total
            $order->total = $totalOrder;
            $order->save();

            return response()->json(['message' => 'Orden insertada correctamente', 'order' => $order], 201);
        } catch (\Exception $e) {
            // Capturar cualquier excepción y devolver un mensaje de error
            return response()->json(['error' => 'Error al insertar la orden: ' . $e->getMessage()], 500);
        }
    }
    public function obtenerMesas()
    {
        try {
            // Obtener todas las mesas
            $mesas = Mesa::all();

            return response()->json(['mesas' => $mesas], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las mesas: ' . $e->getMessage()], 500);
        }
    }
}
