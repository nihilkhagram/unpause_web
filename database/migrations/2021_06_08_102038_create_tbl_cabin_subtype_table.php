<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCabinSubtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cabin_subtype', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cabin_type_id')->unsigned();
            $table->foreign('cabin_type_id')->references('id')->on('tbl_cabin_type');
            $table->tinyInteger('Is_stock')->comment('1=yes,0=no');
            $table->bigInteger('Stock_qty')->default('0');
            $table->string('cabin_subtype_title',100)->nullable();
            $table->string('cabin_subtype',100)->notnullable();
            $table->string('cabin_subtype_size',100)->notnullable();
            $table->double('cabin_subtype_price');
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
        Schema::dropIfExists('tbl_cabin_subtype');
    }
}
