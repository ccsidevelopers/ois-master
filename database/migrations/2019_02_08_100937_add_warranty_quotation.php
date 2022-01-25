<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWarrantyQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_profile', function (Blueprint $table) {
           $table->string('warranty_label');
           $table->string('quotation_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_profile', function (Blueprint $table) {
            $table->dropColumn('warranty_label');
            $table->dropColumn('quotation_path');

        });
    }
}
