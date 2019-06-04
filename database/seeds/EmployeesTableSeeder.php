<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/employees.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {

                $user = User::where('email', '=', $row->email)->first();

                if (!is_null($user)) {
                    Employee::updateOrCreate([
                        'employee_no' => $row->id_number
                    ], [
                        'user_id' => $user->id,
                        'first_name' => $row->first_name,
                        'last_name' => $row->last_name,
                        'middle_name' => $row->middle_name,
                        'date_hired' => $row->start_date,
                        'ext' => $row->ext,
                        'gender' => (string)$row->gender,
                    ]);
                }
            }
        });
    }
}
