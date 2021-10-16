<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustUsersWithSignupField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users',function(Blueprint $table){
                    $table->dropColumn('phone');
                    $table->dropColumn('image');
                    $table->dropColumn('sex');
                    $table->dropColumn('address');
                    $table->boolean('profile_created');
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
        Schema::table('users',function(Blueprint $table){
            $table->string('phone');
            $table->string('image');
            $table->boolean('sex');
            $table->string('address');
            $table->dropColumn('profile_created');
        });
    }
}
