<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnerships', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('user_id');
            $table->uuid('commodity_id');
            $table->integer('quantity');
            $table->decimal('amount');
            $table->decimal('duration');
            $table->decimal('expected_return');
            $table->decimal('real_amount_sold')->default(0);
            $table->integer('warehouse_id');
            $table->tinyInteger('status')->comment('1 for on-going partnership, 2 for cancelled partnership ,3 completed partnership, 4 closed');
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
        Schema::dropIfExists('partnerships');
    }
}
