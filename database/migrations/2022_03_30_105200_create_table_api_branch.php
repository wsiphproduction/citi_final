<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableApiBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_branch', function (Blueprint $table) {
            $table->id();
            $table->string('JOB_DESCRIPTION');
            $table->string('JOB_CODE');
            $table->string('OPERATING_UNIT_NAME');
            $table->string('COMPANYID');
            $table->string('ORGANIZATION_ID');
            $table->string('ASSIGNED_STORE');
            $table->string('STORE_CODE');
            $table->string('DIVISION');
            $table->string('DIVISION_CODE');
            $table->string('DEPARTMENTS');
            $table->string('DEPARTMENT_CODE');
            $table->string('STORE_TYPE');
            $table->string('BRANCH_SIZE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_branch');
    }
}
