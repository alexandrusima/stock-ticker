<?php

namespace App\Services\Communcation\Sender;

use App\Services\Communcation\Connection\ConnectionInterface;
use Psr\Http\Message\ResponseInterface;

interface SenderInterface
{

    public function __construct(ConnectionInterface $connection);

    public function send(string $method, array $postData = [], array $headers = []): ResponseInterface
}
