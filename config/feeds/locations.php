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
            'city' => [
                'field' => 'address.locality'
            ],
            'region' => [
                'field' => 'address.administrative_district_level_1'
            ],
            'postal_code' => [
                'field' => 'address.postal_code'
            ],
            'country' => [
                'field' => 'address.country'
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
            ],
            'street' => [
                'field' => 'streetaddress'
            ],
            'city' => [
                'field' => 'city'
            ],
            'region' => [
                'field' => 'state'
            ],
            'postal_code' => [
                'field' => 'zip'
            ],
            'country' => [
                'field' => 'country'
            ],
        ],
        'brand_identifier' => 'storename'
    ]
];
