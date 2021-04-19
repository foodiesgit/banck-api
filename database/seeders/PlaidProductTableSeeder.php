<?php

namespace Database\Seeders;

use App\Models\PlaidProduct;
use Illuminate\Database\Seeder;

class PlaidProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plaidProducts = ["transactions", "auth", "identity", "assets", "investments", "liabilities", "payment_initiation"];
        foreach ($plaidProducts as $v) {
            PlaidProduct::create([
                'name' => $v,
            ]);
        }
    }
}
