<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempChargeToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_charge_to', function (Blueprint $table) {
            $table->id();
            $table->string('CUSTOMER_NAME')->nullable();
            $table->string('ACCOUNT_NUMBER')->nullable();
            $table->string('BILL_TO_LOCATION')->nullable();
            $table->string('PAYMENT_TERMS')->nullable();
            $table->string('ORGANIZATION_NAME')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_charge_to');
    }
}
