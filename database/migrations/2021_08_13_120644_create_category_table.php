<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->bigIncrements('id');
        $table->string('category_name',250);
            $table->string('category_image',250);
            $table->string('category_short_desc',250);
            $table->string('category_long_desc',250);
            $table->bigInteger('Created_by')->unsigned();
           $table->foreign('Created_by')->references('id')->on('users');
           $table->tinyInteger('Is_active');
           $table->tinyInteger('Is_delete');
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
        Schema::dropIfExists('category');
    }
}
