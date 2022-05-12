<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ap_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('ap_header_id');
            $table->double('amount', 10, 2)->nullable();
            $table->string('company')->nullable();
            $table->string('branch')->nullable();
            $table->string('accountno')->nullable();
            $table->string('department')->nullable();
            $table->string('intercompany')->nullable();
            $table->string('sigment1')->nullable();
            $table->string('sigment2')->nullable();
            $table->text('description')->nullable();
            $table->string('gl_date')->nullable();
            $table->string('type')->nullable();
            $table->string('track_as_asset')->nullable();
            $table->string('asset_book')->nullable();
            $table->string('asset_category')->nullable();
            $table->string('reference1')->nullable();
            $table->string('reference2')->nullable();
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
        Schema::dropIfExists('ap_lines');
    }
}
