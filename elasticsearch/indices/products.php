<?php

return [
    'index' => 'products',
    'body' => [
        'settings' => [
            'number_of_shards' => 2,
            'number_of_replicas' => 1,
        ],
        'mappings' => [
            'properties' => [
                'id' => [
                    'type' => 'keyword',
                ],
                'description' => [
                    'type' => 'text',
                    'analyzer' => 'whitespace',
                ],
                'price_amount' => [
                    'type' => 'integer',
                ],
                'mileage_amount' => [
                    'type' => 'integer',
                ]
            ]
        ]
    ]
];
