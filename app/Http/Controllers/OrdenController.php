<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    public function listarOrdenesListas()
    {
        // Obtener todas las órdenes con detalles de ítems donde el estado sea "listo", "preparando", "esperando" o "cancelado"
        $ordenes = Order::with('detalles.item')
            ->whereIn('status', ['listo', 'preparando', 'esperando', 'cancelado'])
            ->orderByDesc('order_date') // Ordenar por fecha descendente
            ->get();

        $ordenesListo = collect();
        $ordenesPreparando = collect();
        $ordenesEsperando = collect();
        $ordenesCancelado = collect();

        // Iterar sobre cada orden y clasificarla por estado
        foreach ($ordenes as $orden) {
            $nombrePlato = '';

            if ($orden->detalles->isNotEmpty()) {
                $detalle = $orden->detalles->first();
                if ($detalle && $detalle->item) {
                    $nombrePlato = $detalle->item->menuItemName ?? '';
                }
            }

            // Agregar la información simplificada de la orden al array de órdenes correspondiente
            $ordenSimplificada = [
                'orderID' => $orden->orderID,
                'estado' => $orden->status,
                'total' => $orden->total,
                'fecha_orden' => $orden->order_date,
                'mesaID' => $orden->mesaID,
                'menuItemName' => $nombrePlato
            ];

            // Clasificar la orden por estado
            switch ($orden->status) {
                case 'listo':
                    $ordenesListo->push($ordenSimplificada);
                    break;
                case 'preparando':
                    $ordenesPreparando->push($ordenSimplificada);
                    break;
                case 'esperando':
                    $ordenesEsperando->push($ordenSimplificada);
                    break;
                case 'cancelado':
                    $ordenesCancelado->push($ordenSimplificada);
                    break;
            }
        }

        // Combinar todas las colecciones en una sola, en el orden deseado
        $ordenesCombinadas = $ordenesListo->merge($ordenesPreparando)->merge($ordenesEsperando)->merge($ordenesCancelado);

        // Devolver la respuesta como JSON con las órdenes ordenadas
        return response()->json(['ordenes' => $ordenesCombinadas]);
    }
}
