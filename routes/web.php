<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pokemon', [PokemonController::class, 'index']);


