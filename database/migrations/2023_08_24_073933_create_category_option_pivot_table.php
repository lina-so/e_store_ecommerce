<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryOptionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_option', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('option_id')->index();
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->primary(['category_id', 'option_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_option');
    }
}
