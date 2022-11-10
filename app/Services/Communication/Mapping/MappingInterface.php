<?php

namespace App\Services\Communication\Mapping;

interface MappingInterface
{
    public function map(array $item): array;
}
