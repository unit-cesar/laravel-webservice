<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
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

    public function showModel($id)
    {
        return (object)[
          [
            'name' => 'Bakunin',
            'email' => 'bakunin@mail.com'
          ]
        ];
    }
}
