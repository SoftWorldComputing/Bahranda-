<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseCheckoutDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_checkout_data', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->uuid('commodity_id');
            $table->integer('warehouse_id');
            $table->decimal('quantity_to_checkout');
            $table->decimal('amount_left_in_store');
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
        Schema::dropIfExists('warehouse_checkout_data');
    }
}
