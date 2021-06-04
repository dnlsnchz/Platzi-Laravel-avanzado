<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Category;
use App\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(10000, 60000),
        'category_id' => function (array $post) {
            return Category::inRandomOrder()->first()->id;
        },
        'created_by' => function (array $post) {
            return User::inRandomOrder()->first()->id;
        },
    ];
});
