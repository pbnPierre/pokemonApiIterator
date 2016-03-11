<?php

class PokeApiIterator implements Iterator
{
    const API_BASE_URL = 'http://pokeapi.co/api/v2/pokemon/';

    protected
        $currentIndex,
        $count;

    public function rewind()
    {
        $this->currentIndex = 0;
        $pokeApiResult      = json_decode(file_get_contents(self::API_BASE_URL), true);
        $this->count        = $pokeApiResult['count'];
    }

    public function current()
    {
        return json_decode(file_get_contents(self::API_BASE_URL.($this->currentIndex + 1)), true);
    }

    public function key()
    {
        return $this->currentIndex;
    }

    public function next()
    {
        $this->currentIndex++;
    }


    public function valid()
    {
        return $this->currentIndex < $this->count;
    }
}