<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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
            $name = $faker->name;
            DB::table('tbl_users')->insert([
                'email' => $faker->regexify('[A-Za-z]{10}').'@gmail.com',
                'password' => Hash::make('password'),
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'promotions' => 1,
                'userType' => 'C'
                ]);
            }
        }
}
