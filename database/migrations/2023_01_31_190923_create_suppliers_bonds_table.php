<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_bonds', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("id_supplers")->nullable();
            $table->date("Date");
            $table->integer("id_Account")->nullable();
            $table->integer("type")->nullable();
            $table->string("Amount");
            $table->string("Note");
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
        Schema::dropIfExists('suppliers_bonds');
    }
}
