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
                'rules' => 'required|int'
            ],
            'name' => [
                'field' => 'name',
                'rules' => 'required'
            ],
            'phone_number' => [
                'field' => 'phone_number',
                'rules' => 'required'
            ],
            'description' => [
                'field' => 'description',
            ]
        ],
        'brand_identifier' => 'business_name'
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
            ],
            'phone_number' => [
                'field' => 'telephone',
                'rules' => 'required'
            ]
        ],
        'brand_identifier' => 'storename'
    ]
];
