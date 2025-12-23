<?php

return [

    'paths' => ['api/*', 'login', 'logout'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://yourfrontenddomain.com',
    ],

    'allowed_headers' => ['*'],

    'supports_credentials' => false,

];
