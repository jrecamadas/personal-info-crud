<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableFieldsToContactPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_persons', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('contact_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_persons', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('contact_no')->nullable(false)->change();
        });
    }
}
