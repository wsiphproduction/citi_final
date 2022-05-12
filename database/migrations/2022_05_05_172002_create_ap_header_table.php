<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ap_headers', function (Blueprint $table) {
            $table->id();
            $table->string('operating_unit')->nullable();
            $table->string('batch_name')->nullable();
            $table->string('type')->nullable();
            $table->string('trading_partner')->nullable();
            $table->string('supplier_num')->nullable();
            $table->string('supplier_sitename')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('invoicenum')->nullable();
            $table->string('invoice_currency')->nullable();
            $table->double('invoice_amount')->nullable();
            $table->string('gl_date')->nullable();
            $table->string('payment_currency')->nullable();
            $table->string('payment_date')->nullable();
            $table->text('description')->nullable();
            $table->string('match_action')->nullable();
            $table->string('terms_date')->nullable();
            $table->string('terms')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('inhouse_status')->nullable();
            $table->string('oracle_status')->nullable();
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
        Schema::dropIfExists('ap_header');
    }
}
