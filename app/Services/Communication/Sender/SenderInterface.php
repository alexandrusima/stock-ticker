<?php

namespace App\Services\Communication\Sender;

use GuzzleHttp\ClientInterface;

use App\Services\Communcation\Connection\ConnectionInterface;

interface SenderInterface
{

    /**
     * @param $connection ConnectionInterface
     * @param $client ClientInterface
     */
    public function __construct($connection, $client);

    public function get(array $queryParams = []): array;
}
