<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_types', function (Blueprint $table) {
            $table->tinyInteger('id')->unsigned()->autoIncrement();
            $table->string('name');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('user_types')->insert(
            array(
                'name' => 'Employee',
                'created_at' => now(),
                'updated_at' => now()
            )
        );
        DB::table('user_types')->insert(
            array(
                'name' => 'Client',
                'created_at' => now(),
                'updated_at' => now()
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
        Schema::dropIfExists('user_types');
    }
}
