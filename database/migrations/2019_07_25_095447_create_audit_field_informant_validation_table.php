<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditFieldInformantValidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_field_informant_validation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audit_id');
            $table->string('informant_name');
            $table->string('relation_subject');
            $table->string('informant_address');
            $table->string('informant_existance');
            $table->string('informant_remarks');
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
        Schema::dropIfExists('audit_field_informant_validation');
    }
}
