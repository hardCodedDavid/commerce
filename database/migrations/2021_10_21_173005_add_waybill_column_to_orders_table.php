<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaybillColumnToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_id')->nullable();
            $table->double('additional_fee', 10, 2)->default(0);
            $table->enum('payment_type', ['pay_on_delivery', 'prepaid'])->nullable();
            $table->longText('CNS')->nullable();
            $table->string('waybill')->nullable();
            $table->boolean('ready_for_delivery')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['waybill', 'ready_for_delivery', 'CNS', 'payment_id', 'payment_type', 'additional_fee']);
        });
    }
}
