<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Pastikan pakai ini, bukan yang default!

class Mahasiswa extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mahasiswas';
    protected $fillable = ['nama', 'nim', 'jurusan'];
}