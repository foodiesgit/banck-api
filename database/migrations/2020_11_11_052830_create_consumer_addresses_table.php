<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('consumer_id');
            $table->string('address_id');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_city');
            $table->string('address_state');
            $table->string('address_zipcode');
            $table->string('address_type');
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
        Schema::dropIfExists('consumer_addresses');
    }
}
