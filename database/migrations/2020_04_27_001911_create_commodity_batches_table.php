<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommodityBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_batches', function (Blueprint $table) {
            $table->id();
            $table->uuid('commodity_id');
            $table->string('batch_no')->unique();
            $table->decimal('quantity_checked_in');
            $table->decimal('in_stock');
            $table->tinyInteger('is_current')->default(0);
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
        Schema::dropIfExists('commodity_batches');
    }
}
