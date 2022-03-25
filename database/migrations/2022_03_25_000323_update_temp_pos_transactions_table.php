<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTempPosTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temp_pos_transactions', function (Blueprint $table) {
            $table->renameColumn('pos_no', 'universal_trx_id');
            $table->renameColumn('s_qty', 'original_qty');
            $table->dropColumn('qty_with_pcv');
            $table->decimal('original_price', 2);
            $table->decimal('total_discount', 2);
            $table->decimal('total_price', 2);
            $table->string('sale_person');
            $table->integer('store_id');
            $table->string('customer_name');
            $table->timestamp('trx_date')->nullable();
            $table->string('terminal_name');
            $table->string('sales_invoice_receipt_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_pos_transactions', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'total_discount', 'total_price', 'sale_person', 'store_id','cashier', 'trx_date', 'terminal_name', 'sales_invoice_receipt_no']);
            $table->renameColumn('original_qty', 's_qty');
            $table->renameColumn('universal_trx_id', 'pos_no');
            $table->string('qty_with_pcv');
        });
    }
}
