<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CostumerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $customer = Customer::create([
                'client_name' => $faker->firstName . ' ' . $faker->lastName,
                'legal_name' => $faker->firstName . ' ' . $faker->lastName,
                'phone_number' => $faker->phoneNumber,
                'email_address' => $faker->safeEmail,
                'country_code' => 'US',
                'language' => 'en',
            ]);

            $c = Customer::where('id', $customer->id)->first();

            $c->plaidProducts()->attach([
                'costumer_id' => $customer->id,
                'plaid_product_id' => 1,
            ]);
            $c->plaidProducts()->attach([
                'costumer_id' => $customer->id,
                'plaid_product_id' => 2,
            ]);

        }
    }
}
