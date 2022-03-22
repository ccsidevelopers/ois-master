<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditContactListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_contact_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province_id');
            $table->string('municipality_id');
            $table->string('brgy_name');
            $table->string('contact_person');
            $table->string('position');
            $table->string('contact_num');
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
        Schema::dropIfExists('audit_contact_list');
    }
}
