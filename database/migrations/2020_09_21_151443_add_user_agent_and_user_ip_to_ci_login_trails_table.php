<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAgentAndUserIpToCiLoginTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_login_trails', function (Blueprint $table) {
            $table->string('user_agent')->after('address_location');
            $table->string('user_ip')->after('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ci_login_trails', function (Blueprint $table) {
            $table->dropColumn('user_agent');
            $table->dropColumn('user_ip');
        });
    }
}
