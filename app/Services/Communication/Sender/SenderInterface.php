<?php

namespace App\Services\Communication\Sender;

use App\Services\Communcation\Connection\ConnectionInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;

interface SenderInterface
{

    /**
     * @param $connection ConnectionInterface
     * @param $client ClientInterface
     */
    public function __construct($connection, $client);

    public function get(): ResponseInterface;
}
