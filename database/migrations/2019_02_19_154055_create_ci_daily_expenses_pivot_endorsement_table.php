<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiDailyExpensesPivotEndorsementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_daily_expenses_pivot_endorsement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('daily_id');
            $table->integer('endorsement_id');
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
        Schema::dropIfExists('ci_daily_expenses_pivot_endorsement');
    }
}
