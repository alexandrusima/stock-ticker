<?php

namespace App\Services\Communication\Connection;

class Connection implements ConnectionInterface
{
    private ?string $url = null;
    private array $headers = [];

    public function addHeader(string $name, array | string | int $value): ConnectionInterface
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): ConnectionInterface
    {
        $this->url = $url;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;        
    }
}
