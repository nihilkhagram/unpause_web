<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblExtrachargeServicelistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_extracharge_servicelist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ec_category_id')->unsigned();
            $table->foreign('ec_category_id')->references('id')->on('tbl_extracharge_category');
            $table->string('service_name',250);
            $table->double('Service_default_price');
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
        Schema::dropIfExists('tbl_extracharge_servicelist');
    }
}
