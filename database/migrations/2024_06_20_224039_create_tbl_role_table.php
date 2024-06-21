<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoleTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_role', function (Blueprint $table) {
            $table->string('role', 25)->primary();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_role');
    }
}
