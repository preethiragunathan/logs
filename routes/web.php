<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogRequestResponse;

// Route::middleware([LogRequestResponse::class])->group(function () {
//     Route::get('/', function () {
//         return view('welcome');
//     });
//     // Add more routes here
// });

// Route::get('/example', [ExampleController::class, 'index'])->middleware('log.requests');

Route::middleware(['log'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});