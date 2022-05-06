<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('ar_header_id');
            $table->string('company')->nullable();
            $table->string('branch')->nullable();
            $table->string('accountno')->nullable();
            $table->string('department')->nullable();
            $table->string('intercompany')->nullable();
            $table->string('sigment1')->nullable();
            $table->string('sigment2')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('unit_price', 10, 2)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->text('memo_line')->nullable();
            $table->text('reference')->nullable();
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
        Schema::dropIfExists('ar_lines');
    }
}
