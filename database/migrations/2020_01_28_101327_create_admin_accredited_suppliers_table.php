<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccreditedSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accredited_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('admin_id');
            $table->string('category');
            $table->string('supp_name');
            $table->string('con_num');
            $table->text('supp_address');
            $table->string('contact_person');
            $table->string('sup_email');
            $table->text('email_subj');
            $table->date('date_bi');
            $table->string('sup_bir');
            $table->string('sup_tin');
            $table->string('sup_tor');
            $table->string('sup_categorization');
            $table->text('sup_descrip');
            $table->string('sup_terms');
            $table->text('sup_proposal');
            $table->text('sup_results');
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
        Schema::dropIfExists('admin_accredited_suppliers');
    }
}
