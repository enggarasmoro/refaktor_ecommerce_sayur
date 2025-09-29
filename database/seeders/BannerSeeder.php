<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'name' => 'DISKON HINGGA 75RB - PENGGUNA BARU!',
            'image' => 'banner1.jpg',
            'status' => '1'
        ]);

        Banner::create([
            'name' => 'FLASH SALE 50% OFF',
            'image' => 'banner2.jpg',
            'status' => '1'
        ]);

        Banner::create([
            'name' => 'WEEKEND SPECIAL DEALS',
            'image' => 'banner3.jpg',
            'status' => '1'
        ]);

        Banner::create([
            'name' => 'PROMO GAJIAN BULAN INI',
            'image' => 'banner4.jpg',
            'status' => '1'
        ]);
    }
}
