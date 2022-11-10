<?php

namespace App\Services\Communication\Receivers;

use App\Services\Communication\Mapping\MappingInterface;

class TickerReceiver extends AbstractReceiver implements TickerReceiverInterface
{
    /**
     * @var MappingInterface
     */
    protected $mapper;

    /**
     * @inherit
     */
    protected function normalizeResult(array $resp): array
    {
        if (empty($resp)) {
            throw new \InvalidArgumentException('Empty Rest response');
        }

        if (!isset($resp['prices']) || empty($resp['prices'])) {
            throw new \InvalidArgumentException('Empty price list');
        }

        $items = [];
        foreach ($resp as $company) {
            try {
                $items[] = $this->mapper->map($company);
            } catch (\Throwable) {
                continue;
            }
        }

        return $items;
    }
}
