<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\StatusCategory;

class InsertStatusCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statusCategories = [
            ['name'   => 'Applicant Job Status'],
            ['name'   => 'Employee Job Status'],
            ['name'   => 'Employee Trigger Status']
        ];

        foreach($statusCategories as $statusCategory) {
            StatusCategory::updateOrCreate(
                ['name' => $statusCategory['name']],
                ['name' => $statusCategory['name']]
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
        Schema::dropIfExists('status_categories');
    }
}
