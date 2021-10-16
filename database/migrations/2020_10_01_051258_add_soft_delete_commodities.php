<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::table('commodities', function (Blueprint $table) {
        //     if(!$table->deleted_at) 
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // //
        // Schema::table('commodities', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });
    }
}
