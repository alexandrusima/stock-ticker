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

    public function get(): array
    {
        /** @var ResponseInterface $resp */
        $resp = $this->client->request(
            'GET',
            $this->connection->getUrl(),
            [
                'headers' => $this->connection->getHeaders()
            ]
        );

        if ($resp->getStatusCode() !== 200) {
            throw new \RuntimeException('Something whent wrong ! Status code ' . $resp->getStatusCode());
        }
        
        if (!$resp->getBody()) {
            return [];
        }

        try {
            $data = json_decode($resp->getBody(), true);
        } catch (\JsonException) {
            return [];
        }
        return $data;
    }
}
