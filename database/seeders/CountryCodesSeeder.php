<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = "public/asset/json/country-codes-iso3166.json";
        $countries = json_decode(file_get_contents($path), true); 

        foreach ($countries as $country) {
            DB::table('countries_iso_3166')->insert([
                "name" => $country['name'],
                "alpha_2" => $country['alpha-2'],
                "alpha_3" => $country['alpha-3'],
                "country_code" => $country['country-code'],
                "iso_3166_2" => $country['iso_3166-2'],
                "region" => $country['region'],
                "sub_region" => $country['sub-region'],
                "intermediate_region" => $country['intermediate-region'],
                "region_code" => $country['region-code'],
                "sub_region_code" => $country['sub-region-code'],
                "intermediate_region_code" => $country['intermediate-region-code']
            ]);
        }
    }
}
