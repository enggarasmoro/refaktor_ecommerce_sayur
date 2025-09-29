<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            [
                'username' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'nohp' => '08551242392',
                'password' => bcrypt('123456789'),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
