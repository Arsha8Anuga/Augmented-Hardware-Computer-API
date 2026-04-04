<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Node extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'nodes';

    protected $fillable = ['root_id', 'data'];
}