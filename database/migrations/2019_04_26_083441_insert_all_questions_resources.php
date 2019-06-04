<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertAllQuestionsResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resources = [
            [
                'name' => 'all_questions_api',
                'display_name' => 'General Questions API',
                'description' => 'This is a authorization access on Questions API',
            ],
            [
                'name' => 'all_question_responses_api',
                'display_name' => 'General Question Responses API',
                'description' => 'This is a authorization access on Question Responses API',
            ],
        ];

        foreach ($resources as $resource) {
            Resource::updateOrCreate(
                [
                    'name' => $resource['name'],
                ],
                [
                    'display_name' => $resource['display_name'],
                    'description' => $resource['description'],
                ]
            );
        }
    }
}
