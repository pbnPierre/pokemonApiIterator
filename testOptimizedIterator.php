<?php

include(__DIR__.'/Optimized/PokeApiIterator.php');

$iterator = new PokeApiIterator();

echo 'Listing All pokemons'."\n";
foreach ($iterator as $pokemonNumberMinusOne => $pokemonData) {
    printf(
        "%d - %s \n",
        $pokemonNumberMinusOne+1,
        $pokemonData['name']
    );
}