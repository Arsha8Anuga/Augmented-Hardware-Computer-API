<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Test extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'test';
    protected $fillable = ['name'];
}