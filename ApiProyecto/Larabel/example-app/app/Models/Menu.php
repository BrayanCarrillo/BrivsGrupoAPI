<?php

// app/Models/Menu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'tbl_menu';
    protected $primaryKey = 'menuID';
    public $timestamps = false;

    // Relación uno a muchos con los elementos del menú
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menuID', 'menuID');
    }
}
