<?php

use App\Ingredients;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 200; $i++)
        {
            $faker = Faker\Factory::create();

            DB::table('tbl_ingredients')->insert([
                'name' => $faker->unique->word,
                ]);
        }

        for ($i = 0; $i <= 100; $i++)
        {
            $faker = Faker\Factory::create();

            DB::table('tbl_supplier_items')->insert([
                'supplier_id' => $faker->numberBetween(1,51),
                'ingredient_id' => $faker->numberBetween(1,200),
                'price' => $faker->numberBetween(1,15),
                'details' => $faker->sentence,
                ]);
        }
    }
}
