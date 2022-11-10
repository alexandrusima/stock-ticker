<?php

namespace App\Services\Communication\Receivers;

use App\Services\Communication\Mapping\MappingInterface;

class CompaniesReceiver extends AbstractReceiver implements CompaniesReceiverInterface
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
