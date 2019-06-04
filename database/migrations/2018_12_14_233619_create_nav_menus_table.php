<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->unsigned();
            $table->string('icon')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('description');
            $table->string('slug');
            $table->mediumInteger('sequence')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_menus');
    }
}
