<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $timezones = ['CET', 'CST', 'GMT+1'];
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            User::create([
                'first_name' => $faker->firstname,
                'last_name' => $faker->lastname,
                'email' => $faker->unique()->email,
                'password' => bcrypt('password'),
                'timezone' => $timezones[array_rand($timezones)],
            ]);
        }
    }
}