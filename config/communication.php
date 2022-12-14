<?php

return [
    'connections' => [
        'default' => 'companies',
        'companies' => [
            'url' => env('COMPANIES_URL'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'

            ]
        ],
        'ticker' => [
            'url' => env('RAPID_API_URL'),
            'headers' => [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => env('RAPID_KEY'),
                'X-RapidAPI-Host' => env('RAPID_HOST')
            ]
        ]
    ],
    'mapping' => [
        'companies' => [
            'Company Name' => 'name',
            'Symbol' => 'symbol'
        ],
        'ticker' => [

            'date' => 'date',
            'open' => 'o',
            'high' => 'h',
            'low' => 'l',
            'close' => 'c',
            'volume' => 'volume',
            'adjclose' => 'adjclose'
        ]
    ]
];
