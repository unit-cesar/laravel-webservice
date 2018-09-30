<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Habilita para inserção
    protected $fillable = [
      'name',
      'description',
      'price',
      'image',
      'status',
    ];
}
