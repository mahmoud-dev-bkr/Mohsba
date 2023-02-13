<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManuProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manu_product_orders', function (Blueprint $table) {
            $table->id();
            $table->integer("id_product")->nullable();
            $table->integer("id_Manu_order")->nullable();
            $table->string("Qun");
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
        Schema::dropIfExists('manu_product_orders');
    }
}
