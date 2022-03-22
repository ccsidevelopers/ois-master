<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItDeptChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_dept_checklist', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_check');
            $table->string('user_id');
            $table->string('noted_by');
            $table->string('status');
            $table->string('note_remarks');
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
        Schema::dropIfExists('it_dept_checklist');
    }
}
