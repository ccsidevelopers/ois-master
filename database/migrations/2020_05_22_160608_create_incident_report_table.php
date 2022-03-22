<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidentReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incident_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->text('report_remarks');
            $table->string('1st_approver_id');
            $table->text('1st_approver_remarks');
            $table->string('admin_approver_id');
            $table->text('admin_remarks');
            $table->string('it_id');
            $table->text('it_remarks');
            $table->string('general_status');
            $table->string('photo_file_path');
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
        Schema::dropIfExists('incident_report');
    }
}
