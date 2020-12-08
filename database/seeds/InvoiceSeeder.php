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
            $startDate = 2015-01-01;
            $endDate = 2020-12-31;
            $date = $faker->dateTimeBetween('-0 days', '+4 days')->format('Y-m-d');

            DB::table('tbl_invoice')->insert([
                'pay_id' => $faker->numberBetween(1, 3),
                'user_id' => $faker->numberBetween(1, 51),
                'status' => $faker->randomElement(['R', 'O', 'C']),
                'pickup_date' => $date,
                'pickup_time' => $faker->time(),
                'amount' => $faker->numberBetween(5.00, 100.00),
                'date' => $date,
                ]);
            }
        
    }
}
