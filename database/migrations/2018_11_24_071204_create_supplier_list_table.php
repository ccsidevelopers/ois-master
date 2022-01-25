<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supp_name');
            $table->string('supp_contact_phone');
            $table->string('supp_contact_mobile');
            $table->string('supp_email');
            $table->string('supp_address');
            $table->string('supp_contact_person');
            $table->string('category_id');
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
        Schema::dropIfExists('supplier_list');
    }
}
