<?php

namespace App\Services\Communication\Sender;

use App\Services\Communcation\Connection\ConnectionInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;

class Sender implements SenderInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection = null; 

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param $connection ConnectionInterface
     * @param $client ClientInterface
     */
    public function __construct($connection, $client)
    {
        $this->connection = $connection;
        $this->client = $client;
    }

    public function get(): ResponseInterface
    {
        return $this->client->request('GET', $this->connection->getUrl(), $this->connection->getHeaders());
    }
}
