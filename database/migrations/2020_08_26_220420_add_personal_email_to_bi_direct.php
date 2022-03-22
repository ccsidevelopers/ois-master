<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPersonalEmailToBiDirect extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->string('direct_personal_email',255)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bi_direct_applicant_endorsement', function (Blueprint $table) {
            $table->dropColumn('direct_personal_email');
        });
    }
}
