<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLiftTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lift_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lifttype_title',100)->notnullable();
            $table->double('Lifttype_price');
            $table->tinyInteger('Is_active');
           $table->tinyInteger('Is_delete');
        //  $table->foreign('Created_by')->references('id')->on('users');
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
        Schema::dropIfExists('tbl_lift_type');
    }
}
