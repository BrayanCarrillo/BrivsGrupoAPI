<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'tbl_staff';
    protected $primaryKey = 'staffID';
    public $timestamps = false;
}
