<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypePhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ci_login_trails', function (Blueprint $table) {
            $table->string('type');
            $table->string('photo_path');
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
            $table->dropColumn('type');
            $table->dropColumn('photo_path');
        });
    }
}
