<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class USStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = "public/asset/json/us-states.json";
        $states = json_decode(file_get_contents($path), true); 

        foreach ($states as $state) {
            DB::table('us_states')->insert([
                "abbreviation" => $state['abbreviation'],
                "name" => $state['name']
            ]);
        }
    }
}
