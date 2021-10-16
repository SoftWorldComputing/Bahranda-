<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustFaqsAndReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('faqs',function(Blueprint $table){
                    $table->dropColumn('faq_answer');
                 $table->dropColumn('faq_question');
        });
        Schema::table('faqs',function(Blueprint $table){
            $table->text('faq_answer');
            $table->text('faq_question');
            });
        Schema::table('reviews',function(Blueprint $table){
            $table->dropColumn('review_text');
        });
        Schema::table('reviews',function(Blueprint $table){
            $table->text('review_text');
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
        Schema::table('faqs',function(Blueprint $table){
                    $table->dropColumn('faq_answer');
                     $table->dropColumn('faq_question');
        });
        Schema::table('faqs',function(Blueprint $table){
            $table->string('faq_answer');
            $table->string('faq_question');
            });
        Schema::table('reviews',function(Blueprint $table){
            $table->dropColumn('review_text');
        });
        Schema::table('reviews',function(Blueprint $table){
            $table->string('review_text');
        });
    }
}
