<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePcvTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pcv', function (Blueprint $table) {
            $table->string('approver_name')->nullable();
            $table->boolean('tl_approved')->nullable();
            $table->boolean('py_staff_approved')->nullable();
            $table->boolean('dh_approved')->nullable();
            $table->integer('pcfr_id')->nullable();
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
            $table->dropColumn(['approver_name', 'tl_approved', 'py_staff_approved', 'dh_approved','pcfr_id']);
        });
    }
}
