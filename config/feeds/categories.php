<?php
/*
 Map format:
 [
    'map' => [
        <MODEL ATTRIBUTE> => [
            'field' => <JSON/XML ATTRIBUTE TO MAP TO THE MODEL ATTRIBUTE ABOVE>,
            'rules' => <OPTIONAL LIST OF LARAVEL VALIDATION RULES>
        ],
        ...
    ],
    'brand_identifier' => <JSON/XML DATA ATTRIBUTE THAT REPRESENTS THE BRAND THIS LOCATION IS A PART OF>
 ]
 */

return [
    'json' => [
        'map' => [
            'feed_id' => [
                'field' => 'id',
                'rules' => 'required|string'
            ],
            'name' => [
                'field' => 'category_data.name',
                'rules' => 'required'
            ]
        ]
    ],
    'xml' => [
        'map' => [
            'feed_id' => [
                'field' => 'id',
                'rules' => 'required'
            ],
            'name' => [
                'field' => 'name',
                'rules' => 'required'
            ]
        ]
    ]
];
