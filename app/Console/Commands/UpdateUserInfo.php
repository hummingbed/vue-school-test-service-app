<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Faker\Factory as Faker;

class UpdateUserInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-info';
    protected $description = 'Update user\'s firstname, lastname, and timezone to new random ones';

    /**
     * Execute the console command.
     */
       

    public function handle()
    {
        $faker = Faker::create();
        $timezones = ['CET', 'CST', 'GMT+1'];

        $users = User::all();

        foreach ($users as $user) {
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->timezone = $timezones[array_rand($timezones)];
            $user->save();
        }

        $this->info('User information updated successfully.');
    }
}
