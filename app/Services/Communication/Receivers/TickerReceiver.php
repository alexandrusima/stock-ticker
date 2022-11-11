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

        $prices = $resp['prices'];
        $items = [];
        foreach ($prices as $company) {
            try {
                $item = $this->mapper->map($company) ?? [];

                // @todo figure out the place for this.
                $date = new \DateTime('now');
                $date->setTimestamp((float) $item['date']);

                $item['x'] = (float) $date->format('U');
                $item['date'] = $date->format(\DateTime::ISO8601);

                $items[] = $item;
            } catch (\Throwable $e) {
                continue;
            }
        }

        return $items;
    }
}
