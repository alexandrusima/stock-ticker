<?php

namespace App\Services\Communication\Connection;

interface ConnectionInterface
{
    public function addHeader(string $name, array | string | int $value);

    public function addHeaders(array $headers): self;

    public function getUrl(): ?string;

    public function setUrl(string $url): ConnectionInterface;
}
