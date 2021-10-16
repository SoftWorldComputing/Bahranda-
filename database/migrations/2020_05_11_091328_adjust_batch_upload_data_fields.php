<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustBatchUploadDataFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('batch_price_upload_data',function(Blueprint $table){
            $table->dropColumn('sell_price');
            $table->decimal('state_tax');
            $table->decimal('transportation');
            $table->decimal('warehousing');
            $table->decimal('other_costs');
            $table->decimal('profit_margin');
            $table->decimal('total_purchase_price');
            $table->decimal('target_sale_price');
          
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
        Schema::table('batch_price_upload_data',function(Blueprint $table){
            $table->decimal('sell_price');
            $table->dropColumn('state_tax');
            $table->dropColumn('transportation');
            $table->dropColumn('warehousing');
            $table->dropColumn('other_costs');
            $table->dropColumn('profit_margin');
        });
    }
}
