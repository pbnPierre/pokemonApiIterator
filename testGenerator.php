<?php

function simplePokemonApiGenerator() {
    $apiUrl = 'http://pokeapi.co/api/v2/pokemon/';
    $pokeApiResult = json_decode(file_get_contents($apiUrl), true);

    for ($i = 1; $i <= $pokeApiResult['count']; $i++) {
        yield json_decode(file_get_contents($apiUrl.($i + 1)), true);
    }
}

function pokemonApiGenerator($pageSize = 20) {
    $apiUrl = 'http://pokeapi.co/api/v2/pokemon/';

    $page = 0;
    $cacheIndex = 0;
    $pokeApiCache =  json_decode(
        file_get_contents(
            sprintf(
                '%s?limit=%d&offset=%d',
                $apiUrl,
                $pageSize,
                $pageSize * $page
            )
        ),
        true
    );

    for ($i = 0; $i <= $pokeApiCache['count']; $i++) {
        yield $pokeApiCache['results'][$cacheIndex];
        $cacheIndex = ($cacheIndex +1) % $pageSize;
        if (isset($cache[$cacheIndex][$cacheIndex]) && $i !== $pokeApiCache['count']) {
            $page++;
            $pokeApiCache =  json_decode(
                file_get_contents(
                    sprintf(
                        '%s?limit=%d&offset=%d',
                        $apiUrl,
                        $pageSize,
                        $pageSize * $page
                    )
                ),
                true
            );
        }
    }
}


printf("Optimized PokeApi Generator \n");
$generator = pokemonApiGenerator();
foreach ($generator as $pokemonNumberMinusOne => $pokemonData) {
    printf(
        "%d - %s \n",
        $pokemonNumberMinusOne+1,
        $pokemonData['name']
    );
}

printf("Simple PokeApi Generator \n");
$generator = simplePokemonApiGenerator();
foreach ($generator as $pokemonNumberMinusOne => $pokemonData) {
    printf(
        "%d - %s \n",
        $pokemonNumberMinusOne+1,
        $pokemonData['name']
    );
}