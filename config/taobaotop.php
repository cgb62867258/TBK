<?php

return [
    'default'     => 'app',
    'connections' => [
        'app' => [
            'app_key'    => env('TBK_APP_KEY'),
            'app_secret' => env('TBK_SECRET_KEY'),
            'format'     => env('TBK_FORMAT', 'json'),
        ]
    ],
];
