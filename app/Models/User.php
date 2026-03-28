<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    // Bagian ini yang diubah:
    protected $fillable = [
        'username', // 'name' diganti jadi 'username'
        'email', 
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}