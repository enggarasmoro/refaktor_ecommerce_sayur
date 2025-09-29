<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kota')->insert([
            [
                'nama' => 'Surabaya',
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Sidoarjo',
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
