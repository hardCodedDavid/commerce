<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('purchase_item_id')->nullable();
            $table->foreignId('sale_item_id')->nullable();
            $table->string('no');
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->timestamp('date_sold')->nullable();
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
        Schema::dropIfExists('item_numbers');
    }
}
