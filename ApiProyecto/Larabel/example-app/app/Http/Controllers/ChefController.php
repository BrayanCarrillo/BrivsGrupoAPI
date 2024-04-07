<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\MenuItem;

class ChefController extends Controller
{
    // Obtener todos los detalles de todas las órdenes con información del menú
    public function getAllOrdersWithDetails()
    {
        // Obtener todas las órdenes con sus detalles relacionados
        $orders = Order::orderBy('order_date', 'asc')->get();
        
        $formattedOrders = $orders->map(function ($order) {
            $orderDetails = OrderDetail::where('orderID', $order->orderID)->get();
            $formattedDetails = $orderDetails->map(function ($detail) use ($order) {
                $menuItem = MenuItem::find($detail->itemID);
    
                if ($menuItem) {
                    // El objeto $menuItem existe, puedes acceder a sus propiedades de forma segura
                    return [
                        'ID de orden' => $detail->orderID,
                        'menu' => $menuItem->menu->menuName, // Obtener el nombre del menú a través de la relación
                        'menuItemName' => $menuItem->menuItemName, // Obtener el nombre del item del menú
                        'cantidad' => $detail->quantity,
                        'estado' => $order->status,
                    ];
                } else {
                    // Manejar el caso donde $menuItem es null
                    return [
                        'ID de orden' => $detail->orderID,
                        'menu' => null,  // O algún valor predeterminado
                        'menuItemName' => null, // O algún valor predeterminado
                        'cantidad' => $detail->quantity,
                        'estado' => $order->status,
                    ];
                }
            });

            return [
                'orderID' => $order->orderID,
                'order_date' => $order->order_date,
                'total' => $order->total,
                'mesaID' => $order->mesaID,
                'orderDetails' => $formattedDetails,
            ];
        });

        return response()->json(['orders' => $formattedOrders]);
    }

    // Actualizar estado de orden a preparando, listo o cancelado
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:preparando,listo,cancelado',
        ]);

        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Estado de orden actualizado con éxito']);
    }

    // Eliminar una orden específica
    public function deleteOrder($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        // Eliminar la orden y sus detalles relacionados
        $order->delete();
        OrderDetail::where('orderID', $orderId)->delete();

        return response()->json(['message' => 'Orden eliminada con éxito']);
    }
}
