<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTempTruckers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_truckers', function (Blueprint $table) {
            $table->renameColumn('slps_no', 'SLPSNO')->nullable()->change();
            $table->renameColumn('plate_no', 'PLATENUMBER')->nullable()->change();
            $table->renameColumn('trucker', 'TRUCKER_SHIPPER')->nullable()->change();
            $table->renameColumn('mode_of_payment', 'NAMESHIP')->nullable()->change();
            $table->string('STATUS')->nullable();
            $table->string('VANNUMBER')->nullable();
            $table->string('TRUCKER_NDEX')->nullable();
            $table->string('DESTINATION')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_truckers', function (Blueprint $table) {
            $table->renameColumn('SLPSNO', 'slps_no')->nullable(false)->change();
            $table->renameColumn('PLATENUMBER', 'plate_no')->nullable(false)->change();
            $table->renameColumn('TRUCKER_SHIPPER', 'trucker')->nullable(false)->change();
            $table->renameColumn('NAMESHIP', 'mode_of_payment')->nullable(false)->change();
            $table->dropColumn(['STATUS', 'VANNUMBER', 'TRUCKER_NDEX', 'DESTINATION']);
        });
    }
}
