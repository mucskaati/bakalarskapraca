<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'activated' => true,
        'created_at' => $faker->dateTime,
        'deleted_at' => null,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'last_login_at' => $faker->dateTime,
        'last_name' => $faker->lastName,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Layout::class, static function (Faker\Generator $faker) {
    return [
        'columns' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'height' => $faker->randomFloat,
        'name' => $faker->firstName,
        'rows' => $faker->randomNumber(5),
        'type' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        'width' => $faker->randomFloat,
        
        'margin' => ['en' => $faker->sentence],
        'xaxis' => ['en' => $faker->sentence],
        'yaxis' => ['en' => $faker->sentence],
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Slider::class, static function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTime,
        'default' => $faker->randomFloat,
        'default_function' => $faker->text(),
        'layout_id' => $faker->sentence,
        'max' => $faker->randomFloat,
        'min' => $faker->randomFloat,
        'step' => $faker->randomFloat,
        'title' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Checkbox::class, static function (Faker\Generator $faker) {
    return [
        'attribute_name' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'layout_id' => $faker->sentence,
        'title' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Experiment::class, static function (Faker\Generator $faker) {
    return [
        'ajax_url' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'description' => $faker->text(),
        'export' => $faker->boolean(),
        'layout_id' => $faker->sentence,
        'title' => $faker->sentence,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
