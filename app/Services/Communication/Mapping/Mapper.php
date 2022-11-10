<?php

namespace App\Services\Communication\Mapping;

class Mapper implements MappingInterface
{
    private array $config;

    public function __construct(array $mapperConfig)
    {
        if (empty($mapperConfig)) {
            throw new \InvalidArgumentException('Empty Mapper Config.');
        }        
        $this->config = $mapperConfig;
    }

    public function map(array $item): array 
    {
         $retItem = [];
        foreach ($this->config as $key => $value) {
            $retItem[$value] = array_key_exists($key, $item) ? $item[$key] : null;
        }

        return $retItem;
    }
}
