<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail; // Asegúrate de importar el modelo OrderDetail si aún no lo has hecho

class Order extends Model
{
    protected $table = 'tbl_order';
    protected $primaryKey = 'orderID';
    public $timestamps = false;

    // Definición de la relación con los detalles de la orden
    public function detalles()
    {
        return $this->hasMany(OrderDetail::class, 'orderID', 'orderID');
    }
}
