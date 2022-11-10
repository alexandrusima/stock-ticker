<?php

namespace App\Services\Communication\Mapping;

interface TickerMappingInterface extends MappingInterface
{
    public const DATE_FIELD = 'date';
    public const OPEN_FIELD = 'open';
    public const HIGH_FIELD = 'high';
    public const LOW_FIELD = 'low';
    public const CLOSE_FIELD = 'close';
    public const VOLUME_FIELD = 'volume';
    public const ADJCLOSE_FIELD = 'adjclose';

    public const MAPPING = [
        static::DATE_FIELD => 'date',
        static::OPEN_FIELD => 'open',
        static::HIGH_FIELD => 'high',
        static::LOW_FIELD => 'low',
        static::CLOSE_FIELD => 'close',
        static::VOLUME_FIELD => 'volume',
        static::ADJCLOSE_FIELD => 'adjclose',
    ];
}
