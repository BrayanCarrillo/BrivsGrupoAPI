<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class InsertarOrdenController extends Controller
{
    public function insertarOrden(Request $request)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'status' => 'required|string',
            'total' => 'required|numeric',
            'order_date' => 'required|date',
            'mesaID' => 'required|integer',
            'orderID' => 'required|integer|unique:tbl_order' // Asegurar que orderID sea único
        ]);

        // Obtener los datos del request
        $status = $request->input('status');
        $total = $request->input('total');
        $order_date = $request->input('order_date');
        $mesaID = $request->input('mesaID');
        $orderID = $request->input('orderID'); // Nuevo campo para orderID

        // Crear un nuevo objeto Order con los datos proporcionados
        $order = new Order();
        $order->orderID = $orderID; // Asignar el valor de orderID
        $order->status = $status;
        $order->total = $total;
        $order->order_date = $order_date;
        $order->mesaID = $mesaID;

        // Guardar el nuevo objeto en la base de datos
        $order->save();

        return response()->json(['message' => 'Orden insertada correctamente'], 201);
    }
}
