<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillOfSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_of_sales', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("id_customers")->nullable();
            $table->date("Date_start");
            $table->date("Date_end");
            $table->string("grace_period");
            $table->string("Note");
            $table->string("Terms_conditions");
            $table->string("Reviews");
            $table->string("Attachments");
            $table->integer("id_projects")->nullable();
            $table->integer("id_tasks")->nullable();
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
        Schema::dropIfExists('bill_of_sales');
    }
}
