<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Status;

class PopulateStatusCategoryIdAndDisplaySequenceInStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statuses = [
            [
                'name'   => 'New',
                'status_category_id' => '1',
                'display_sequence' => '1'
            ],
            [
                'name'   => 'For Exam',
                'status_category_id' => '1',
                'display_sequence' => '2'
            ],
            [
                'name'   => 'For Interview',
                'status_category_id' => '1',
                'display_sequence' => '3'
            ],
            [
                'name'   => 'For Job Offer',
                'status_category_id' => '1',
                'display_sequence' => '4'
            ],
            [
                'name'   => 'For Further JO Review',
                'status_category_id' => '1',
                'display_sequence' => '5'
            ],
            [
                'name'   => 'Send Offer',
                'status_category_id' => '1',
                'display_sequence' => '6'
            ],
            [
                'name'   => 'Pending Offer',
                'status_category_id' => '1',
                'display_sequence' => '7'
            ],
            [
                'name'   => 'Offer Not Yet Accepted',
                'status_category_id' => '1',
                'display_sequence' => '8'
            ],
            [
                'name'   => 'Offer Accepted',
                'status_category_id' => '1',
                'display_sequence' => '9'
            ],
            [
                'name'   => 'Reapplication',
                'status_category_id' => '1',
                'display_sequence' => '11'
            ],
            [
                'name'   => 'Failed Exam',
                'status_category_id' => '1',
                'display_sequence' => '12'
            ],
            [
                'name'   => 'Failed Interview',
                'status_category_id' => '1',
                'display_sequence' => '13'
            ],
            [
                'name'   => 'Offer Rejected',
                'status_category_id' => '1',
                'display_sequence' => '14'
            ],
            [
                'name'   => 'Archive',
                'status_category_id' => '1',
                'display_sequence' => '15'
            ],
            [
                'name'   => 'Probationary',
                'status_category_id' => '2',
                'display_sequence' => '1'
            ],
            [
                'name'   => 'Regular',
                'status_category_id' => '2',
                'display_sequence' => '2'
            ],
            [
                'name'   => 'Suspended',
                'status_category_id' => '2',
                'display_sequence' => '3'
            ],
            [
                'name'   => 'Resigned',
                'status_category_id' => '2',
                'display_sequence' => '4'
            ],
            [
                'name'   => 'Terminated',
                'status_category_id' => '2',
                'display_sequence' => '5'
            ],
            [
                'name'   => 'Hired',
                'status_category_id' => '3',
                'display_sequence' => '10'
            ],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(
                [
                    'name' => $status['name']
                ],
                [
                    'name' => $status['name'],
                    'status_category_id' => $status['status_category_id'],
                    'display_sequence' => $status['display_sequence'],
                ]
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
        Schema::dropIfExists('statuses');
    }
}
