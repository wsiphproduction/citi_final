<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePcvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcv', function (Blueprint $table) {
            $table->double('amount')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pcv', function (Blueprint $table) {
            $table->dropColumn(['amount', 'cancelled_by', 'cancelled_date', 'remarks']);
        });
    }
}
