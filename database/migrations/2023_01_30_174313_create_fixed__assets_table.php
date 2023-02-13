 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed__assets', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name_ar");
            $table->string("name_en");
            $table->integer("id_dep_Asset")->nullable();
            $table->string("Uint");
            $table->string("Tex");
            $table->string("Note");
            $table->string("barCode");
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
        Schema::dropIfExists('fixed__assets');
    }
}
