<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {

    $name = $faker->name;
    $data = [
        'name' => $name,
        'email' => $faker->unique()->safeEmail,
    ];

    echo 'Creating fake contact: ' . $name . PHP_EOL; // Saída no terminal; PHP_EOL = End of line / Fim de linha

    return $data;

});
