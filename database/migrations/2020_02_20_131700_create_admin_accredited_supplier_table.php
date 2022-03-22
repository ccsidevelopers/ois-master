<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccreditedSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accredited_supplier_management_app', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pass_id');
            $table->string('categ_sup');
            $table->text('eq_desc_sup');
            $table->text('sup_rem');
            $table->string('req_stat');
            $table->text('approver_remarks');
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
        Schema::dropIfExists('admin_accredited_supplier_management_app');
    }
}
