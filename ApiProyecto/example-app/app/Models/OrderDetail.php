<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'tbl_orderdetail';
    protected $primaryKey = 'orderDetailID';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderID');
    }

    public function item()
    {
        return $this->belongsTo(MenuItem::class, 'itemID');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesaID');
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class, 'itemID');
    }
}
