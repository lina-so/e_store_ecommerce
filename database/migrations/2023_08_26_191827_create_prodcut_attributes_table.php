<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prodcut_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('value_id');
            $table->float('price');
            $table->string('sku');
            $table->integer('stock');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodcut_attributes');
    }
};
