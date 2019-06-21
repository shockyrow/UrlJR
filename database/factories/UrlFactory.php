<?php

/* @var $factory Factory */

use App\Url;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Url::class, function (Faker $faker) {
    return [
        'hash' => $faker->sha1 . $faker->md5,
        'real_url' => $faker->url,
    ];
});
