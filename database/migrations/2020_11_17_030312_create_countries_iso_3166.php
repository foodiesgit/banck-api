<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesIso3166 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries_iso_3166', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("alpha_2");
            $table->string("alpha_3");
            $table->string("country_code");
            $table->string("iso_3166_2")->nullable();
            $table->string("region")->nullable();
            $table->string("sub_region")->nullable();
            $table->string("intermediate_region")->nullable();
            $table->string("region_code")->nullable();
            $table->string("sub_region_code")->nullable();
            $table->string("intermediate_region_code")->nullable();
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
        Schema::dropIfExists('countries_iso_3166_2');
    }
}
