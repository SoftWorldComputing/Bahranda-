<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->integer('warehouse_id');
            $table->tinyInteger('status')->default(0)->comment("0 is Pending,1 authorized, 2 declined");
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
        Schema::dropIfExists('warehouse_checkouts');
    }
}
