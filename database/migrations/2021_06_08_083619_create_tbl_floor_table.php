<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFloorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_floor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('Floor_title',100)->notnullable();
            $table->double('Floor_price');
            $table->tinyInteger('Is_active');
           $table->tinyInteger('Is_delete');
           $table->bigInteger('Created_by')->unsigned();
           $table->foreign('Created_by')->references('id')->on('users');
          $table->dateTime('Created_dt');
           $table->dateTime('Modified_dt');
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_floor');
    }
}
