<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@schoolah.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'phone_number' => '12345678',
            'is_change_password' => true,
            'school_id' => null,
            'address' => 'jln. ketapang he'
        ]);
    }
}
