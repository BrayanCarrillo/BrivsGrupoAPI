<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'tbl_menuitem';
    protected $primaryKey = 'itemID';
    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menuID');
    }
}
