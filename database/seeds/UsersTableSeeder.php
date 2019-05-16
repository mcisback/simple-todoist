<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the user seeds.
     * Create 20 new user
     * Admin is not present for now
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\User::class, 20)->create();
    }
}
