<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasyConstraintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_constraints', function (Blueprint $table) {
            $table->id();
            $table->integer("id_Asset_from")->nullable();
            $table->integer("id_Asset_to")->nullable();
            $table->date("Date");
            $table->string("Note");
            $table->string("Amount");
            $table->integer("type");
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
        Schema::dropIfExists('easy_constraints');
    }
}
