<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("id_supplers")->nullable();
            $table->date("Date_start");
            $table->date("Date_end");
            $table->date("Date_Groce_Period");
            $table->string("Note");
            $table->string("Terms_Condition");
            $table->string("Reviews");
            $table->string("Attachments");
            $table->integer("id_Project")->nullable();
            $table->integer("id_Task")->nullable();
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
        Schema::dropIfExists('purchase_invoices');
    }
}
