<?php

namespace App\Services\Communication\Connection;

final class Connection implements ConnectionInterface
{
    private ?string $url = null;
    private array $headers = [];

    public function __construct(?string $url = null)
    {
        $this->url = $url;    
    }

    public function addHeader(string $name, string | int $value): ConnectionInterface
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function addHeaders(array $headers): ConnectionInterface
    {
        foreach ($headers as $header => $value) {
            $this->addHeader($header, $value);
        }

        return $this;
    }
}
