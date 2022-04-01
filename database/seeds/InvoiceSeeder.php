<?php

use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 50; $i++)
        {
            $faker = Faker\Factory::create();
            $date = $faker->dateTimeBetween('-1 years', '+4 days')->format('Y-m-d');

            DB::table('tbl_invoice')->insert([
                'user_id' => $faker->numberBetween(1, 51),
                'order_id' => $faker->numberBetween(1,51),
                'paid' => $faker->numberBetween(0, 1),
                'amount' => $faker->numberBetween(5.00, 100.00)+'.00',
                'date' => $date,
                ]);
            }
        
    }
}
