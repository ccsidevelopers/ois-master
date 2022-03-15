<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiDailyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ci_daily_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('daily_id');
            $table->string('label',255);
            $table->string('amount',100);
            $table->string('from',50);
            $table->string('or',50);
            $table->text('or_attachment');
            $table->text('remarks');
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
        Schema::dropIfExists('ci_daily_expenses');
    }
}
