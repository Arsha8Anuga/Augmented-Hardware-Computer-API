<?php

use App\Http\Controllers\DashboardController;
use App\Models\Test;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mongo-test', function () {
    Test::create(['name' => 'Zena']);
    return Test::all();
});

Route::get('/dashboard/{path?}', [DashboardController::class, 'index'])
    ->where('path', '.*');
