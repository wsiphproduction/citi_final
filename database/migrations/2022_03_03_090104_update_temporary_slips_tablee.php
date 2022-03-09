<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTemporarySlipsTablee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporary_slips', function (Blueprint $table) {
            $table->string('approver_name')->nullable();
            $table->dropColumn(['received_by', 'received_date']);
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
            $table->dropColumn('approver_name');
            $table->string('received_by')->nullable();
            $table->date('received_date')->nullable();
        });
    }
}
