<?php

use App\Models\ClientContact;
use Illuminate\Database\Seeder;

class ClientContactsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/client_contacts.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                ClientContact::updateOrCreate([
                    'id' => $row->id
                ], [
                    'client_id'     => $row->client_id,
                    'name'          => $row->name,
                    'email'         => 'kcandelario@fullscale.io',
                    'contact_no'    => 12345
                ]);
            }
        });
    }
}
