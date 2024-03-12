<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MenuItem;

class ListaVentasController extends Controller
{
    public function listarOrdenes()
    {
        $ordenes = OrderDetail::with('order', 'menuItem')->get();

        $ordenesVendidas = [];
        foreach ($ordenes as $orden) {
            $menuName = $orden->menuItem ? $orden->menuItem->menu->menuName : 'N/A';

            $ordenVenta = [
                'Numero de Orden' => $orden->order->orderID,
                'Menu' => $menuName,
                'Nombre del Plato' => $orden->menuItem ? $orden->menuItem->menuItemName : 'N/A',
                'Cantidad' => $orden->quantity,
                'Estado' => $orden->order->status,
                'Total (COP)' => $orden->order->total,
                'Fecha' => $orden->order->order_date,
            ];
            $ordenesVendidas[] = $ordenVenta;
        }

        return response()->json(['ordenes' => $ordenesVendidas]);
    }
}
