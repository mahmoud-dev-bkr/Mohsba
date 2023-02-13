<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientBondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_bonds', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("id_customers")->nullable();
            $table->date("Date");
            $table->integer("id_Account")->nullable();
            $table->integer("type");
            $table->string("Note");
            $table->string("Amount");
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
        Schema::dropIfExists('client_bonds');
    }
}
