<?php

return [

    /**
     * mode: 'xml' or 'attribute'
     * path: paths starting with '/'
     *  ex. 'xml' = '/resources/xml', 'attribute' = '/app/Entities'
     */
    'metadata' => [
        'mode' => env('DOCTRINE_METADATA_MODE', 'attribute'),
        'path' => env('DOCTRINE_METADATA_PATH', '/app/Entities'),
    ],
];
