<?php

namespace App\Services\Communication\Connection;

interface ConnectionInterface
{
    public function addHeader(string $name, string | int $value);
    public function addHeaders(array $headers): self;
}
