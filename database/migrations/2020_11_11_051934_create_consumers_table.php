<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->string('ssn');
            $table->string('phone');
            $table->string('email');
            $table->string('citizenship_status');
            $table->string('citizenship_country');
            $table->string('occupation');
            $table->string('source_of_income');
            $table->string('expected_activity');
            $table->string('pep');
            $table->string('ip_address');
            $table->string('user_id');
            $table->string('contact_phone_id');
            $table->string('contact_email_id');
            $table->string('kyc_status');
            $table->string('idv_required');
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
        Schema::dropIfExists('consumers');
    }
}
