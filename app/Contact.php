<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Habilita para inserção no BD
    protected $fillable = [
        'name',
        'email',
    ];

    public function indexModel()
    {
        return (object)[
            [
                'name' => 'Bakunin',
                'email' => 'bakunin@mail.com'
            ],
            [
                'name' => 'Proudhon',
                'email' => 'proudhon@mail.com'
            ]
        ];
    }

    public function showModel()
    {
        return (object)[
            [
                'name' => 'Bakunin',
                'email' => 'bakunin@mail.com'
            ]
        ];
    }
}
