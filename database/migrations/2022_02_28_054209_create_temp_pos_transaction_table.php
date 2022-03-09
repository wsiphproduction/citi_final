<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempPosTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_pos_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('pos_no');
            $table->string('barcode');
            $table->text('description');
            $table->integer('s_qty');
            $table->integer('qty_with_pcv');
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
        Schema::dropIfExists('temp_pos_transactions');
    }
}
