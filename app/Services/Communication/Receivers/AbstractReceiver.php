<?php

namespace App\Services\Communication\Receivers;

use App\Services\Communication\Sender\SenderInterface;
use App\Services\Communication\Mapping\MappingInterface;

abstract class AbstractReceiver implements ReceiverInterface
{
    /**
     * @var SenderInterface
     */
    protected $sender;

    /**
     * @var MappingInterface
     */
    protected $mapper;


    /**
     * @param SenderInterface $sender
     * @param MappingInterface $mapper
     */
    public function __construct($sender, $mapper)
    {
        $this->sender = $sender;
        $this->mapper = $mapper;
    }

    public function fetch(array $queryParams = []): array
    {
        try {
            $resp = $this->sender->get($queryParams);
            $results = $this->normalizeResult($resp);
        } catch (\Throwable) {
            return [];
        }

        return $results;
    }

    /**
     * Builds assoc array from decoded assoc response body.
     * @param array $resp
     * @return array
     * @throws \InvalidArgumentException when normalization cannot be achived.
     */
    abstract protected function normalizeResult(array $resp): array;
}
