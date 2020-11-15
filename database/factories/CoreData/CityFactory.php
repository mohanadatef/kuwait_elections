<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Core_Data\City;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Models Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the modal factory definitions for
| your application. Factories provide a convenient way to generate new
| modal instances for testing / seeding your application's database.
|
*/
$factory->define(City::class, function (Faker $faker) {
    static $order = 1;
    return [
        'title' => $faker->unique()->city,
        'country_id' => $faker->numberBetween($min = 1, $max = 20),
        'status' => 1,
        'order'   => $order++
    ];
});
