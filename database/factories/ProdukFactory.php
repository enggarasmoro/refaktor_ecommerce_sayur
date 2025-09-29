<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produk;
use Faker\Generator as Faker;

$factory->define(Produk::class, function (Faker $faker) {
    $harga = $faker->numberBetween(10000,150000);
    $discountPercent = $faker->randomElement([null,5,10,15,20,25,30]);
    $hargaDiskon = $discountPercent ? (int) round($harga - ($harga * $discountPercent/100)) : $harga;
    return [
        'nama' => $faker->words(2, true),
        'id_kategori' => 1, // adjust if categories seeded
        'info' => $faker->sentence(4),
        'image' => 'https://picsum.photos/seed/'.uniqid().'/600/600',
        'video_url' => $faker->boolean(15) ? 'https://www.w3schools.com/html/mov_bbb.mp4' : null,
        'harga' => $harga,
        'harga_diskon' => $hargaDiskon,
        'discount_percent' => $discountPercent,
        'stok' => $faker->numberBetween(0,100),
        'status' => 1,
        'slug' => $faker->slug,
    ];
});
