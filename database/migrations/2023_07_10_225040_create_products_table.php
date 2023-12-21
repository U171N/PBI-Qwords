<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->primary();
            $table->string('category_id');
            $table->string('name');
            $table->string('product_slug');
            $table->text('description');
            $table->string('product_size');
            $table->string('product_color');
            $table->integer('product_weight');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->decimal('price', 8, 2);
            $table->string('discount_price')->nullable();
            $table->integer('amount');
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
        Schema::dropIfExists('products');
    }
};
