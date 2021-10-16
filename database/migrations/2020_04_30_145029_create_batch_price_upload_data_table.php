<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchPriceUploadDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_price_upload_data', function (Blueprint $table) {
            $table->id();
            $table->uuid('commodity_id');
            $table->string('commodity_name');
            $table->decimal('sell_price');
            $table->decimal('buy_price');
            $table->string('batch_no');
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
        Schema::dropIfExists('batch_price_upload_data');
    }
}
