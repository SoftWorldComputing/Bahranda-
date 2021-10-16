<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnershipBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnership_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->uuid('partnership_id');
            $table->decimal('buy_price');
            $table->decimal('sell_price');
            $table->decimal('state_tax');
            $table->decimal('transportation');
            $table->decimal('warehousing');
            $table->decimal('other_costs');
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
        Schema::dropIfExists('partnership_breakdowns');
    }
}
