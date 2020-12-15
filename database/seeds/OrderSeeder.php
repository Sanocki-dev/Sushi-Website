<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                        // 'user_id' => $faker->numberBetween(1, 51)+'.00',
                // 'status' => $faker->randomElement(['R', 'O', 'C']),
                // 'pickup_date' => $date,
                // 'pickup_time' => $faker->time(),
                // 'amount' => $faker->numberBetween(5.00, 100.00),
                // 'date' => $date,
        
        for ($i = 0; $i <= 50; $i++)
        {
            $faker = Faker\Factory::create();
            $date = $faker->dateTimeBetween('-0 days', '+4 days')->format('Y-m-d');

            DB::table('tbl_orders')->insert([
                'pickup_date' => $date,
                'pickup_time' => $faker->time(),
                'status' => $faker->randomElement(['R', 'O', 'C', 'P']),
            ]);
        }
    }
}
