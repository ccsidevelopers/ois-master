<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bi_endorsements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bi_account_name',100);
            $table->string('project',255);
            $table->string('lob',20);
            $table->text('package');
            $table->text('checking');
            $table->string('account_name',255);
            $table->string('f_name',100);
            $table->string('m_name',100);
            $table->string('l_name',100);
            $table->string('suffix',50);
            $table->string('gender',30);
            $table->string('marital_status',50);
            $table->string('birth_day',100);
            $table->string('birth_month',100);
            $table->string('birth_year',100);
            $table->integer('age');
            $table->string('citizenship',100);
            $table->text('maiden_name');
            $table->string('maiden_f_name',100);
            $table->string('maiden_m_name',100);
            $table->string('maiden_l_name',100);
            $table->text('present_address');
            $table->text('present_muni');
            $table->text('present_province');
            $table->text('permanent_address');
            $table->text('permanent_muni');
            $table->text('permanent_province');
            $table->string('endorser_poc',255);
            $table->text('attach_1');
            $table->text('attach_2');
            $table->text('attach_3');
            $table->text('attach_4');
            $table->string('status',255);
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
        Schema::dropIfExists('bi_endorsements');
    }
}
