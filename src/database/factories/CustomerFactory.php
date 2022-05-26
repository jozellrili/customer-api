<?php

/**
 * @var $factory LaravelDoctrine\ORM\Testing\Factory
 */
$factory->defineAs(App\Entities\Customer::class, 'customer', function (\Faker\Generator $faker) {
    return [
        'id' => $faker->randomDigit(),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->userName,
        'password' => $faker->password,
        'gender' => 'female',
        'country' => 'Australia',
        'city' => 'Norwa',
        'phone' => $faker->phoneNumber,
    ];
});
