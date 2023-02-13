<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepreciablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depreciables', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("id_dep_Asset")->nullable();
            $table->integer("id_Asset")->nullable();
            $table->string("Depreciables_period_type");
            $table->date("Date_from");
            $table->date("Date_to");
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
        Schema::dropIfExists('depreciables');
    }
}
