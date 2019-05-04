<?php

use Faker\Generator as Faker;
$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'category_id'=>rand(1,3),
        'user_id'=>3,
        'title'=>$faker->sentence,
        'description'=>$faker->text,
        'status'=>1,
        'created_at'=>date('Y-m-d h:i:s'),
        'updated_at'=>date('Y-m-d h:i:s'),
    ];
});
