<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_purchase_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('requi_id');
            $table->string('prepared_by');
            $table->string('supplier_id');
            $table->string('term_payment');
            $table->string('po_no');
            $table->date('po_date');
            $table->date('delivery_date');
            $table->integer('total_amount');
            $table->integer('twelve_vat');
            $table->integer('grand_total');
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
        Schema::dropIfExists('admin_purchase_order');
    }
}
