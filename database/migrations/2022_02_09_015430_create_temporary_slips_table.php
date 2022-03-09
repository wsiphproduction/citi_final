<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporarySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temporary_slips', function (Blueprint $table) {
            $table->id();
            $table->string('ts_no');
            $table->string('account_name');
            $table->double('amount');
            $table->double('running_balance');
            $table->text('description');
            $table->string('status');
            $table->string('approval_code')->nullable();
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('received_by');
            $table->date('received_date')->nullable();
            $table->integer('user_id')->unsigned();
            $table->date('date_created')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_slips');
    }
}
