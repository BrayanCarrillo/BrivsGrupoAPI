<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class Order extends Model
{
    protected $table = 'tbl_order';
    protected $primaryKey = 'orderID';
    public $timestamps = false;

    protected $fillable = ['status', 'total', 'order_date', 'mesaID']; // Agregamos 'status' a los atributos asignables

    // Definición de la relación con los detalles de la orden
    public function detalles()
    {
        return $this->hasMany(OrderDetail::class, 'orderID', 'orderID');
    }
    public $incrementing = true;
}
