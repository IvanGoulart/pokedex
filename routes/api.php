<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/pokemon', [PokemonController::class, 'index']);
Route::get('/pokemon/filter', [PokemonController::class, 'filter']);
Route::get('/pokemon/findDetailsPokemon/{id}', [PokemonController::class, 'findDetailsPokemon']);

