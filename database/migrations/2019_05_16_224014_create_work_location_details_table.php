<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkLocationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code');
            $table->string('city');
            $table->string('room_number')->nullable();
            $table->string('floor');
            $table->string('building');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('work_locations')->insert(
            array(
                'country_code' => 'PH',
                'city' => 'Cebu City',
                'room_number' => '11J',
                'floor' => '11th',
                'building' => 'Avenir Building'
            )
        );
        DB::table('work_locations')->insert(
            array(
                'country_code' => 'PH',
                'city' => 'Cebu City',
                'room_number' => '11K',
                'floor' => '11th',
                'building' => 'Avenir Building'
            )
        );
        DB::table('work_locations')->insert(
            array(
                'country_code' => 'PH',
                'city' => 'Cebu City',
                'room_number' => '8A',
                'floor' => '8th',
                'building' => 'Avenir Building'
            )
        );
        DB::table('work_locations')->insert(
            array(
                'country_code' => 'PH',
                'city' => 'Cebu City',
                'floor' => '14th',
                'building' => 'HM Tower'
            )
        );
        DB::table('work_locations')->insert(
            array(
                'country_code' => 'BY',
                'city' => 'Minsk',
                'floor' => ' ',
                'building' => ' '
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_locations');
    }
}
