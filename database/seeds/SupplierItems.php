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
        for ($i = 0; $i <= 30; $i++)
        {
            $faker = Faker\Factory::create();

            DB::table('tbl_supplier_items')->insert([
                'supplier_id' => $faker->numberBetween(1, 11),
                'ingredient_id' => $faker->numberBetween(1, 34),
                'price' => $faker->numberBetween(5.00, 35.00)+'.00',
            ]);
        }
    }
}
