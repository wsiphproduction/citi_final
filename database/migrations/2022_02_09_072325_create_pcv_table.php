<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcv', function (Blueprint $table) {
            $table->id();
            $table->string('slip_no')->nullable();
            $table->double('change');
            $table->string('account_name');
            $table->date('date_created')->useCurrent();
            $table->string('pcv_no');
            $table->string('status');
            $table->string('approval_code')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();            
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('pcv');
    }
}
