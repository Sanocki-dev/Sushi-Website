<?php

use Illuminate\Database\Seeder;

class SupplierItems extends Seeder
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

            DB::table('tbl_suppliers')->insert([
                'supplier_id' => $faker->numberBetween(1, 110),
                'ingredient_id' => $faker->numberBetween(1, 51),
                'price' => $faker->price(),
            ]);
        }
    }
}
