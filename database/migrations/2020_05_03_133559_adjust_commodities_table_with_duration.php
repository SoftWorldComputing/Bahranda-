<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustCommoditiesTableWithDuration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('commodities', function (Blueprint $table) {
            //
            $table->decimal('duration')->after('availability');
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
        Schema::table('commodities', function (Blueprint $table) {
            //
            $table->dropColumn('duration')->after('availability');
        });
        
    }
}
