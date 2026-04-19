<?php

use App\Http\Controllers\Api\DashboardApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('dashboard')->group(function () {

    Route::get('/{path?}', [DashboardApiController::class, 'get'])
        ->where('path', '.*');

    Route::post('/root', [DashboardApiController::class, 'createRoot']);

    Route::delete('/root/{id}', [DashboardApiController::class, 'deleteRoot']);
    
    Route::put('/root/{id}', [DashboardApiController::class, 'updateRoot']);  

    Route::post('/{path?}', [DashboardApiController::class, 'store'])
        ->where('path', '.*');

    Route::put('/{path}', [DashboardApiController::class, 'update'])
        ->where('path', '.*');

    Route::delete('/{path}', [DashboardApiController::class, 'destroy'])
        ->where('path', '.*');
    
});

Route::get('/', function () {
    $routes = collect(Route::getRoutes())->map(function ($route) {
        return [
            'uri' => $route->uri(),
            'method' => $route->methods()[0]
        ];
    })->filter(fn($route) => str_contains($route['uri'], 'api/'));

    return response()->json($routes->values());
});
