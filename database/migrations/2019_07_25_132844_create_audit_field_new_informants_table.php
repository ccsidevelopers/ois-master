<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditFieldNewInformantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_field_new_informants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audit_id');
            $table->string('informants_name');
            $table->string('relation_subject');
            $table->string('address');
            $table->string('remarks');
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
        Schema::dropIfExists('audit_field_new_informants');
    }
}
