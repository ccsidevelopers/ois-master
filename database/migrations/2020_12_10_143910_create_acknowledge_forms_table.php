<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcknowledgeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acknowledge_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_id');
            $table->string('lbc_branch');
            $table->string('office_loc_dep_pos');
            $table->string('cnum_email');
            $table->string('admin_id');
            $table->string('status');
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
        Schema::dropIfExists('acknowledge_forms');
    }
}
