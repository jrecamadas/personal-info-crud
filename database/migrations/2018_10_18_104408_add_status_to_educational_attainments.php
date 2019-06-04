<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToEducationalAttainments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educational_attainments', function (Blueprint $table) {
            $table->boolean('is_active')->default(1)->after('attainment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educational_attainments', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
