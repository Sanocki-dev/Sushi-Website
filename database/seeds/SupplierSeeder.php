<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++)
        {
            $faker = Faker\Factory::create();

            DB::table('tbl_suppliers')->insert([
                'name' => $faker->company(),
                'phone' => $faker->phoneNumber,
                'email' => $faker->email(),
                'website' => $faker->url,
                'address' => $faker->address(),
                'comments' => $faker->sentence()
            ]);
        }
    }
}
