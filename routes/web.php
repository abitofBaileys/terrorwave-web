<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/terrorwave', function() {
    return redirect('/');
});

// When a GET request is being made to this route, run the Randomizer controller's buildForm() method
Route::get('/','App\Http\Controllers\Randomizer@buildForm');

// When a POST request is being made to this route, run the Randomizer controller's makeRom() method
Route::post('/terrorwave','App\Http\Controllers\Randomizer@makeRom');

// When a GET request is being made to this route, run the Randomizer controller's deleteRoms() method
Route::get('/cleanup','App\Http\Controllers\Randomizer@deleteRoms');
