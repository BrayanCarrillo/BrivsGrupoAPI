<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultasController extends Controller
{
    public function mostrarDetallesDeMesa()
    {
        $resultados = DB::table('tbl_order')
            ->join('tbl_orderdetail', 'tbl_order.orderID', '=', 'tbl_orderdetail.orderID')
            ->join('tbl_menuitem', 'tbl_orderdetail.itemID', '=', 'tbl_menuitem.itemID')
            ->join('tbl_staff', 'tbl_order.mesaID', '=', 'tbl_staff.staffID')
            ->select(
                'tbl_staff.username as staff_name',
                'tbl_order.mesaID',
                'tbl_menuitem.menuItemName',
                'tbl_order.total'
            )
            ->get();

        return response()->json($resultados);
    }
}
