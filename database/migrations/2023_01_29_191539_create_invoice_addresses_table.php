<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_addresses', function (Blueprint $table) {
            $table->id();
            $table->string("city");
            $table->integer("clientsID")->nullable();
            $table->string("street_name");
            $table->string("Country");
            $table->string("Zep_Code");
            $table->string("buildingNumber");
       
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
        Schema::dropIfExists('invoice_addresses');
    }
}
