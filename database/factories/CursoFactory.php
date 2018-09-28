<?php

use Faker\Generator as Faker;

$factory->define(App\Curso::class, function (Faker $faker) {

    $name = $faker->jobTitle;
    $data = [
        'name' => $name,
        'description' => $faker->sentence(4, false),
        'price' => $faker->randomFloat(2, 2, 10),
        'image' => 'img/cursos/default.png',
        'status' => $faker->randomElement(['y', 'n']),
    ];

    echo 'Creating fake curso: ' . $name . PHP_EOL; // Saída no terminal; PHP_EOL = End of line / Fim de linha

    return $data;

});
