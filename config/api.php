<?php

return [
	'connections' => [
		'companies' => [
			'url' => env('COMPANIES_URL'),
			'headers' => [
				'Content-Type' => 'application/json'
			]
		],
		'ticker' => [
			'url' => env('COMPANIES_URL'),
			'headers' => [
				'Content-Type' => 'application/json',
				'X-RapidAPI-Key' => env('RAPID_KEY'),
				'X-RapidAPI-Host' => env('RAPID_HOST')
			]
		]
	]
];
