<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlacholderToGovernmentAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('government_agencies', function (Blueprint $table) {
            $table->string('placeholder')->nullable()->after('mask');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('government_agencies', function (Blueprint $table) {
            $table->dropColumn('placeholder');
        });
    }
}
