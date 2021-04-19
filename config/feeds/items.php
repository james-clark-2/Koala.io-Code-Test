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
                'rules' => 'required'
            ],
            'name' => [
                'field' => 'item_data.name',
                'rules' => 'required|string',
            ],
            'category_feed_id' => [
                'field' => 'item_data.category_id',
                'rules' => 'required'
            ],
            'active' => [
                'field' => 'item_data.visibility',
                'rules' => 'in:PUBLIC,PRIVATE',
                'transform' => fn ($value) => $value === 'PUBLIC'
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
            ],
            'description' => [
                'field' => 'description'
            ],
            'active' => [
                'field' => 'isdisabled',
                'rules' => [\Illuminate\Validation\Rule::in(['true', 'false'])],
                'transform' => fn ($value) => $value === 'false'
            ]
        ]
    ]
];
