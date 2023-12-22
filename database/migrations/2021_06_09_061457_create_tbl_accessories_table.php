<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accessories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('Linked_with',['lift','floor']);
            $table->bigInteger('Linked_with_id')->unsigned();
            $table->foreign('Linked_with_id')->references('id')->on('tbl_floor');
            $table->tinyInteger('Is_stock')->comment('1=yes,0=no');
            $table->bigInteger('Stock_qty')->default('0');
            $table->string('accessories_title',100)->nullable();
            $table->string('accessories_type',100)->notnullable();
            $table->string('accessories_size',100)->notnullable();
            $table->double('accessories_price');
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
        Schema::dropIfExists('tbl_accessories');
    }
}
