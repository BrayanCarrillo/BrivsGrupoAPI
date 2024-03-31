<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Order;

class ChefController extends Controller
{
    // Obtener todos los detalles de un pedido por su ID
    public function getOrderDetails($orderId)
    {
        $orderDetails = OrderDetail::where('orderID', $orderId)->get();
        return response()->json($orderDetails);
    }

    // Actualizar estado de orden a preparando y listo
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:preparando,listo',
        ]);

        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Estado de orden actualizado con éxito']);
    }

    // Obtener todas las órdenes
    public function getAllOrders()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    // Eliminar orden de la lista
    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->delete();

        return response()->json(['message' => 'Orden eliminada correctamente']);
    }

    // Eliminar un pedido por su ID
    public function deleteOrderDetail($orderDetailId)
    {
        $orderDetail = OrderDetail::findOrFail($orderDetailId);
        $orderDetail->delete();

        return response()->json(['message' => 'Detalle de orden eliminado correctamente']);
    } 
}
