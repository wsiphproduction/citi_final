<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTempBranchTableeee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_branch', function (Blueprint $table) {
            $table->string('store_size');
            $table->string('store_type');
//            $table->double('budget')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_branch', function (Blueprint $table) {
            $table->dropColumn(['store_type', 'store_size']);
//            $table->double('budget')->nullable(false)->change();
        });
    }
}
