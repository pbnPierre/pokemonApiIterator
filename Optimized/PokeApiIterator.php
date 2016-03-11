<?php

class PokeApiIterator implements Iterator
{
    const API_BASE_URL = 'http://pokeapi.co/api/v2/pokemon/';
    const DEFAULT_PAGE_SIZE = 2;

    protected
        $apiCache,
        $apiCacheIndex,
        $currentIndex,
        $count,
        $currentPage;

    public function __construct($pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->pageSize = $pageSize;
    }

    public function rewind()
    {
        $this->count         = null;
        $this->apiCache      = null;
        $this->currentIndex  = 0;

        $this->fetchPageData(0);
    }

    public function current()
    {
        if ($this->apiCache == null) {
            $this->currentPage++;
        }

        return $this->apiCache[$this->apiCacheIndex];
    }

    public function key()
    {
        return $this->currentIndex;
    }

    public function next()
    {
        $this->currentIndex++;
        $this->apiCacheIndex++;

        if (!isset($this->apiCache[$this->apiCacheIndex])) {
            $this->fetchPageData($this->currentPage);
        }
    }

    public function valid()
    {
        return $this->currentIndex < $this->count;
    }

    protected function fetchPageData($page)
    {
        $apiResult = json_decode(
            file_get_contents(
                sprintf(
                    '%s?limit=%d&offset=%d',
                    self::API_BASE_URL,
                    $this->pageSize,
                    $this->pageSize * $page
                )
            ),
            true
        );

        $this->count = $apiResult['count'];
        $this->apiCache = $apiResult['results'];
        $this->apiCacheIndex = 0;
    }
}