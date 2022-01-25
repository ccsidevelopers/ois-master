<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFromViewAndToViewToMessageInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_info', function (Blueprint $table) {
            $table->string('from_view',50)->after('to_user_id');
            $table->string('to_view',50)->after('from_view');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('message_info', function (Blueprint $table) {
            $table->dropColumn('from_view');
            $table->dropColumn('to_view');
        });
    }
}
