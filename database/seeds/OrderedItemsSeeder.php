<?php

use Illuminate\Database\Seeder;

class OrderedItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 300; $i++)
        {
            $faker = Faker\Factory::create();
            DB::table('tbl_ordered_items')->insert([
                'invoice_id' => $faker->numberBetween(1, 50),
                'menu_id' => $faker->numberBetween(1, 110),
                'quantity' => $faker->numberBetween(1, 10),
                ]);
            }
        
    }
}
