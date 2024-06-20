<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'tbl_mesa';
    protected $primaryKey = 'mesaID';
    public $timestamps = false;

    protected $fillable = ['activate']; // Agrega 'estatus' a los atributos asignables
}
