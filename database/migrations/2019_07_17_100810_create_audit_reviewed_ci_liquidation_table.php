<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditReviewedCiLiquidationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_reviewed_ci_liquidation_remarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fund_id');
            $table->integer('users_id');
            $table->string('audit_remarks');
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
        Schema::dropIfExists('audit_reviewed_ci_liquidation_remarks');
    }
}
