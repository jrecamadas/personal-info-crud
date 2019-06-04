<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatusesTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->tinyInteger('status_category_id')->nullable()->unsigned()->after('description');
            $table->tinyInteger('display_sequence')->nullable()->unsigned()->after('status_category_id');

            $table->foreign('status_category_id')->references('id')->on('status_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function(Blueprint $table){
            $table->dropForeign('statuses_status_category_id_foreign');
            $table->dropColumn('status_category_id');
            $table->dropColumn('display_sequence');
        });
    }
}
