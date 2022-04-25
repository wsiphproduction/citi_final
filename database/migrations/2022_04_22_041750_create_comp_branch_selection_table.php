<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompBranchSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_branch_selection', function (Blueprint $table) {
            $table->id();
            $table->string('COMPANY_NAME')->nullable();
            $table->string('COMPANY_CODE')->nullable();
            $table->string('BRANCH_CODE')->nullable();
            $table->string('VENDOR_ID')->nullable();
            $table->string('VENDOR_SITE_ID')->nullable();
            $table->string('VENDOR_SITE_CODE')->nullable();
            $table->string('TERMS_NAME')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comp_branch_selection');
    }
}
