<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ReferralType;

class InsertReferralTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $referralTypes = [
            ['name'   => 'Referral'],
            ['name'   => 'Social Media'],
            ['name'   => 'Job Portal'],
            ['name'   => 'Word of Mouth'],
            ['name'   => 'Walk-In']
        ];

        foreach ($referralTypes as $referralType) {
            ReferralType::updateOrCreate(
                ['name' => $referralType['name']],
                ['name' => $referralType['name']]
            );
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
