<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{

    public function getDataApiPokemon(string $apiUrl): object
    {

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            return $response;
        }

        if ($response->serverError()) {
            return (object) [
                'error' => true,
                'message' => 'Ocorreu um problema no servidor ao buscar a lista de Pokémon.',
            ];
        }

        return $response;
    }

    public function getHabitatApiPokemon(string $apiUrlImage): object
    {
        $response = Http::get($apiUrlImage);

        if ($response->successful()) {
            return $response;
        }

        if ($response->serverError()) {
            return (object) [
                'error' => true,
                'message' => 'Ocorreu um problema no servidor ao buscar o habitat do Pokémon.',
            ];
        }

        return $response;
    }

    public function getDetailsApiPokemon(string $apiUrlImage): object
    {
        $response = Http::get($apiUrlImage);

        if ($response->successful()) {
            return $response;
        }
        if ($response->serverError()) {
            return (object) [
                'error' => true,
                'message' => 'Ocorreu um problema no servidor ao buscar os detalhes do Pokémon.',
            ];
        }
        return $response;
    }
}
