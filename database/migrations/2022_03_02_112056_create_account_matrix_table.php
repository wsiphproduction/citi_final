<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountMatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_matrix', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->double('amount')->nullable();
            $table->boolean('code');
            $table->boolean('beyond')->nullable();
            $table->boolean('regardless')->nullable();
            $table->boolean('status');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('account_matrix');
    }
}
