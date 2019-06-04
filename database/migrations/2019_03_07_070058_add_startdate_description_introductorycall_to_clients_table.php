<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartdateDescriptionIntroductorycallToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->text('description')->after('notes')->nullable();
            $table->date('start_date')->after('description')->nullable();
            $table->boolean('introductory_call')->default(0)->after('first_month_check_up');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('introductory_call');
            $table->dropColumn('start_date');
            $table->dropColumn('description');
        });
    }
}
