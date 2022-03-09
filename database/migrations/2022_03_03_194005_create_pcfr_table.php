<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcfrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcfr', function (Blueprint $table) {
            $table->id();
            $table->string('pcfr_no');
            $table->string('batch_no');
            $table->date('date_created');
            $table->string('branch');
            $table->string('doc_type');
            $table->string('vendor')->nullable();
            $table->date('from');
            $table->date('to');
            $table->double('total_temp_slip');
            $table->double('total_replenishment');
            $table->double('total_unreplenished');
            $table->double('total_unapproved_pcv');
            $table->double('total_returned_pcv');
            $table->double('total_accounted');
            $table->double('total_pending_replenishment');
            $table->double('pcf_accountability');
            $table->double('pcf_diff');
            $table->double('atm_balance');
            $table->double('cash_on_hand');
            $table->string('status');
            $table->integer('user_id');
            $table->double('amount');
            $table->boolean('tl_approved')->nullable();
            $table->boolean('py_staff_approved')->nullable();
            $table->boolean('dh_approved')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->text('remarks')->nullable();            
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
        Schema::dropIfExists('pcfr');
    }
}
