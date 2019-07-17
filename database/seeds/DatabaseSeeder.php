<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'created_at' => Carbon::now(),
            'password' => bcrypt('securepassword'),
            'role' => 'admin'
        ]);

        DB::table('activities')->insert([
            'user_id' => 1,
            'content' => 'Created a new User',
            'created_at' => Carbon::now(),
        ]);
    }
}
