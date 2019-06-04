<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeesTableForReferralTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_other_details', function (Blueprint $table) {

            $table->integer('referral_type_id')
                ->nullable()
                ->after('referred_by_employee_id');

            $table->string('referral_details')
                ->nullable()
                ->after('referral_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //$table->dropColumn('UserDomainName');
        Schema::table('employee_other_details', function (Blueprint $table) {

            $table->dropColumn('referral_type_id');

            $table->dropColumn('referral_detail');
        });
    }
}
