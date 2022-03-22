<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEncodedTemplateNameAndDateTimeToEndorsementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('endorsements', function (Blueprint $table) {
            $table->text('encoded_template_name')->after('dl_link');
            $table->dateTime('encoded_template_date_time')->after('encoded_template_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endorsements', function (Blueprint $table) {
            $table->dropColumn('encoded_template_name');
            $table->dropColumn('encoded_template_date_time');
        });
    }
}
