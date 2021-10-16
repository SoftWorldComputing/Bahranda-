<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchPriceUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_price_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->integer('no_of_data');
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
        Schema::dropIfExists('batch_price_uploads');
    }
}
