<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundUtilityExpensesTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_utility_expenses_table', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('statement_date');
            $table->string('due_date');
            $table->string('account_number');
            $table->string('amount');
            $table->string('branch');
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
        Schema::dropIfExists('fund_utility_expenses_table');
    }
}
