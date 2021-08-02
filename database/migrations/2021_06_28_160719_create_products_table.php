<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->unique();
            $table->text('description');
            $table->decimal('buy_price');
            $table->decimal('sell_price');
            $table->decimal('discount');
            $table->string('sku')->nullable();
            $table->boolean('in_stock');
            $table->integer('quantity');
            $table->decimal('weight')->nullable();
            $table->text('note')->nullable();
            $table->integer('sold')->default(0);
            $table->boolean('is_listed')->default(false);
            $table->softDeletes();
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
}
