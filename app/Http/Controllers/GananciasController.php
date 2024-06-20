<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Asegúrate de importar el modelo de Order

class GananciasController extends Controller
{
    public function gananciasHoy()
    {
        $ganancias = Order::whereDate('order_date', today())->sum('total');
        return response()->json(['ganancias' => $ganancias]);
    }

    public function gananciasSemana()
    {
        $inicioSemana = now()->startOfWeek();
        $finSemana = now()->endOfWeek();
        $ganancias = Order::whereBetween('order_date', [$inicioSemana, $finSemana])->sum('total');
        return response()->json(['ganancias' => $ganancias]);
    }

    public function gananciasMes()
    {
        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();
        $ganancias = Order::whereBetween('order_date', [$inicioMes, $finMes])->sum('total');
        return response()->json(['ganancias' => $ganancias]);
    }

    public function gananciasTodoElTiempo()
    {
        $ganancias = Order::sum('total');
        return response()->json(['ganancias' => $ganancias]);
    }
}
