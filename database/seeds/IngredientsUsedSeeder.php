<?php

use Illuminate\Database\Seeder;

class IngredientsUsedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 2; $i <= 20; $i++)
        {
            $faker = Faker\Factory::create();
            $items = $faker->numberBetween(2,5);
            for ($j = 0; $j <= $items; $j++)
            {
                DB::table('lk_ingredient_use')->insert([
                    'item_id' => $faker->numberBetween(1,200),
                    'menu_id' => $i
                ]);
            }
        }
    }
}
