<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductMedia;
use Faker\Generator as Faker;

$factory->define(ProductMedia::class, function (Faker $faker) {
    return [
        'produk_id' => 1,
        'type' => 'image',
        'url' => 'https://picsum.photos/seed/'.uniqid().'/600/600',
        'position' => 0,
    ];
});
