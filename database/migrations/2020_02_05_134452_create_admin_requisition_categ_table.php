<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRequisitionCategTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_requisition_categ', function (Blueprint $table) {
            $table->increments('id');
            $table->string('req_id');
            $table->string('req_tor');
            $table->string('req_categ');
            $table->string('req_type_1');
            $table->string('req_type_2');
            $table->string('req_others');
            $table->text('req_remarks');
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
        Schema::dropIfExists('admin_requisition_categ');
    }
}
