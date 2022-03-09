<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTemporarySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_slips', function (Blueprint $table) {
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
        Schema::table('temporary_slips', function (Blueprint $table) {
            $table->dropColumn(['cancelled_by', 'cancelled_date', 'remarks']);
        });
    }
}
