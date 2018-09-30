<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static find($id)
 */
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
