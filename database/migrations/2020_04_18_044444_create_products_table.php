<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('commodity_name');
            $table->text('description');
            $table->decimal('buy_price');
            $table->decimal('sell_price');
            $table->decimal('state_tax');
            $table->decimal('transportation');
            $table->decimal('warehousing');
            $table->decimal('other_costs');
            $table->decimal('quantity_in_stock');
            $table->string('product_image');
            $table->tinyInteger('availability')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
