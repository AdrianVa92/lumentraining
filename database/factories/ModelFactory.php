<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use App\Models\Category;
use App\Models\User;

$factory->define(\App\Models\Category::class, function (Faker\Generator $faker) {
    $user = User::pluck('id')->toArray();
    return [
        'name' => $faker->word,
        'user_id' => $faker->randomElement($user),
    ];
});

$factory->define(\App\Models\Ticket::class, function (Faker\Generator $faker) {
    $user = User::pluck('id')->toArray();
    $category = Category::pluck('id')->toArray();
    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'user_id' => $faker->randomElement($user),
        'category_id' => $faker->randomElement($category),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'email'    => $faker->unique()->email,
        'password' => password_hash('12345', PASSWORD_BCRYPT),
    ];
});
