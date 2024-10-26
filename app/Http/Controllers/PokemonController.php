<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentPage = $request->input('page', 1);
        $apiService = new ApiService();

        $url =  env('POKEMON_API_URL') . "?offset=". (($currentPage - 1) * 10) . "&limit=10";
        $dadosPokemon = $apiService->getDataApiPokemon($url);

        // Verifique a estrutura dos dados antes de acessar 'next' e 'previous'
        $nextPageUrl = isset($dadosPokemon['next']) ? $dadosPokemon['next'] : null;
        $previousPageUrl = isset($dadosPokemon['previous']) ? $dadosPokemon['previous'] : null;

        $pokemonComDetalhes = $this->createArrayInfoPockemon($dadosPokemon['results']);

        return view('pokemon.listPokemon', [
            'dadosPokemon' => $pokemonComDetalhes,
            'nextPageUrl' => $nextPageUrl,
            'previousPageUrl' => $previousPageUrl,
            'currentPage' => $currentPage
        ]);
    }

    public function createArrayInfoPockemon(array $dadosPokemon): array{

        $apiService = new ApiService();

        foreach ($dadosPokemon as $pokemon) {
            $pokemonDetails = $apiService->getDetailsApiPokemon($pokemon['url']);
            $urlApiGetHabitat = env('POKEMON_HABITAT_API_URL').$pokemonDetails['id'];

            $habitat = $apiService->getHabitatApiPokemon($urlApiGetHabitat);

            $pokemonComDetalhes[] = [
                'id' => $pokemonDetails['id'],
                'name' => $pokemonDetails['name'],
                'height'  => $pokemonDetails['height'],
                'weight'  => $pokemonDetails['weight'],
                'types' => collect($pokemonDetails['types'])->pluck('type.name')->implode(', '),
                'img'  => $pokemonDetails['sprites']['back_default'],
                'habitat' => $habitat['names'][2]['name'] ?? "Não encontrado"
            ];
        }

        return $pokemonComDetalhes;
    }

    public function filter(Request $request){
        $currentPage = $request->input('page', 1);
        $apiService = new ApiService();


        // if ($request->filled('type')) {
        //     $query->where('type', 'like', '%' . $request->type . '%');
        // }

        // if ($request->filled('habitat')) {
        //     $query->where('habitat', 'like', '%' . $request->habitat . '%');
        // }

        // Verifica se todos os filtros estão vazios
        if (empty($request->filled('type')) && empty($request->filled('name')) && empty($request->filled('habitat'))) {
            return $this->index($request);
        }else{

        if ($request->filled('name')) {

            $url =  env('POKEMON_API_URL').Str::lower($request->name) . "?offset=". (($currentPage - 1) * 10) . "&limit=10";
            $pokemonDetails = $apiService->getDataApiPokemon($url);

            $urlApiGetHabitat = env('POKEMON_HABITAT_API_URL').$pokemonDetails['id'];
            $habitat = $apiService->getHabitatApiPokemon($urlApiGetHabitat);

            $nextPageUrl = isset($dadosPokemon['next']) ? $dadosPokemon['next'] : null;
            $previousPageUrl = isset($dadosPokemon['previous']) ? $dadosPokemon['previous'] : null;

            $pokemonComDetalhes[] = [
                'id' => $pokemonDetails['id'],
                'name' => $pokemonDetails['name'],
                'height'  => $pokemonDetails['height'],
                'weight'  => $pokemonDetails['weight'],
                'types' => collect($pokemonDetails['types'])->pluck('type.name')->implode(', '),
                'img'  => $pokemonDetails['sprites']['back_default'],
                'habitat' => $habitat['names'][2]['name'] ?? "Não encontrado"
            ];

        }

        if ($request->filled('type')) {

            $url =  env('POKEMON_API_URL').Str::lower($request->name) . "?offset=". (($currentPage - 1) * 10) . "&limit=10";
            $pokemonDetails = $apiService->getDataApiPokemon($url);

            $urlApiGetHabitat = env('POKEMON_HABITAT_API_URL').$pokemonDetails['id'];
            $habitat = $apiService->getHabitatApiPokemon($urlApiGetHabitat);

            $nextPageUrl = isset($dadosPokemon['next']) ? $dadosPokemon['next'] : null;
            $previousPageUrl = isset($dadosPokemon['previous']) ? $dadosPokemon['previous'] : null;

            $pokemonComDetalhes[] = [
                'id' => $pokemonDetails['id'],
                'name' => $pokemonDetails['name'],
                'height'  => $pokemonDetails['height'],
                'weight'  => $pokemonDetails['weight'],
                'types' => collect($pokemonDetails['types'])->pluck('type.name')->implode(', '),
                'img'  => $pokemonDetails['sprites']['back_default'],
                'habitat' => $habitat['names'][2]['name'] ?? "Não encontrado"
            ];

        }


    }
        return view('pokemon.listPokemon', [
            'dadosPokemon' => $pokemonComDetalhes,
            'nextPageUrl' => $nextPageUrl,
            'previousPageUrl' => $previousPageUrl,
            'currentPage' => $currentPage
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function findDetailsPokemon($id)
    {

        $apiService = new ApiService();

        $url =  env('POKEMON_API_URL') . $id;
        $dadosPokemon = $apiService->getDataApiPokemon($url);


        return $dadosPokemon;
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
