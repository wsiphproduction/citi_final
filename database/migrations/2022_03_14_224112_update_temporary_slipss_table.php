<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTemporarySlipssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_slips', function (Blueprint $table) {
            $table->boolean('tl_approved')->nullable();
            $table->boolean('dh_approved')->nullable();
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
            $table->dropColumn(['tl_approved', 'dh_approved']);
        });
    }
}
