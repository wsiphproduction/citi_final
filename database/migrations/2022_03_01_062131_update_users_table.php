<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('position');
            $table->integer('branch_group_id')->nullable();
            $table->string('assign_to');
            $table->string('assign_name');
            $table->integer('role_id')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->dropColumn('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lastname', 'middlename', 'position', 'branch_group_id', 'assign_to', 
                'assign_name', 'role_id','updated_by','created_by']);
            $table->renameColumn('firstname', 'name');
            $table->string('email');
        });
    }
}
