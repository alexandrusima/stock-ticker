<?php 

namespace App\Services\Communication\Mapping;

interface CompanyMappingInterface extends MappingInterface
{
    public const NAME_FIELD = 'Company Name';
    public const STATUS_FIELD = 'Financial Status';
    public const SYMBOL_FILED = 'Symbol';

    public const MAPPING = [
        static::NAME_FIELD => 'name',
        static::STATUS_FIELD => 'status',
        static::SYMBOL_FIELD => 'symbol'
    ];
}
