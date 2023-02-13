<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetDepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_deps', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name_ar");
            $table->string("name_en");
            $table->integer("Depreciable");
            $table->string("Depreciable_methed");
            $table->string("Useful_life");

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
        Schema::dropIfExists('asset_deps');
    }
}
