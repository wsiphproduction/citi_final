<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_headers', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_source')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('class')->nullable();
            $table->string('transaction_type')->nullable();
            $table->text('reference')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('gl_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('bill_to_name')->nullable();
            $table->string('bill_to_number')->nullable();
            $table->string('payment_term')->nullable();
            $table->double('balance_due', 10, 2)->nullable();
            $table->string('inhouse_status')->nullable();
            $table->string('oracle_status')->nullable();
            $table->string('pcv_type')->nullable();
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
        Schema::dropIfExists('ar_header');
    }
}
