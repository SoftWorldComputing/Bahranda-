<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustPartnershipBreakdownWithPurchasedPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('partnership_breakdowns',function(Blueprint $table){
            $table->decimal('profit_margin');
            $table->decimal('purchase_price'); 
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('partnership_breakdowns',function(Blueprint $table){
            $table->decimal('profit_margin');
            $table->decimal('purchase_price'); 
       });
    }
}
