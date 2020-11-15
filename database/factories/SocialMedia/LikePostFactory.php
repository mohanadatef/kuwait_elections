<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Social_Media\LikePost;
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
$factory->define(LikePost::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 3),
        'post_id' => $faker->numberBetween($min = 1, $max = 20),
    ];
});
