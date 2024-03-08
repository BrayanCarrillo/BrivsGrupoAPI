<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class OrdenController extends Controller
{
    public function listarOrdenesListas()
    {
        // Obtener todas las órdenes con detalles de ítems donde el status sea "ready", "preparing" o "waiting"
        $ordenes = Order::with('detalles.item')
            ->whereIn('status', ['ready', 'preparing', 'waiting'])
            ->get();

        $ordenesReady = collect();
        $ordenesPreparing = collect();
        $ordenesWaiting = collect();

        // Iterar sobre cada orden y clasificarla por estado
        foreach ($ordenes as $orden) {
            // Obtener el nombre del plato para la orden actual
            $nombrePlato = $orden->detalles->first()->item->menuItemName;

            // Agregar la información simplificada de la orden al array de órdenes correspondiente
            $ordenSimplificada = [
                'orderID' => $orden->orderID,
                'status' => $orden->status,
                'total' => $orden->total,
                'order_date' => $orden->order_date,
                'mesaID' => $orden->mesaID,
                'menuItemName' => $nombrePlato
            ];

            // Clasificar la orden por estado
            switch ($orden->status) {
                case 'ready':
                    $ordenesReady->push($ordenSimplificada);
                    break;
                case 'preparing':
                    $ordenesPreparing->push($ordenSimplificada);
                    break;
                case 'waiting':
                    $ordenesWaiting->push($ordenSimplificada);
                    break;
            }
        }

        // Combinar todas las colecciones en una sola, en el orden deseado
        $ordenesCombinadas = $ordenesReady->merge($ordenesPreparing)->merge($ordenesWaiting);

        // Devolver la respuesta como JSON con las órdenes ordenadas
        return response()->json(['ordenes' => $ordenesCombinadas]);
    }
}
