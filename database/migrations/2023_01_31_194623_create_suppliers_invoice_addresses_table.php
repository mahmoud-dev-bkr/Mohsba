<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersInvoiceAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_invoice_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer("id_supplers")->nullable();
            $table->string("street_name");
            $table->string("ciby");
            $table->string("Zip_code");
            $table->string("country");
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
        Schema::dropIfExists('suppliers_invoice_addresses');
    }
}
