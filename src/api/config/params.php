<?php
return [
    'adminEmail' => 'admin@example.com',
    'cors' => [
        'Origin' => ['*'],
        'Access-Control-Request-Method' => ['POST', 'GET','OPTIONS','DELETE','PUT'],
        'Access-Control-Request-Headers' => ['*'],
        'Access-Control-Allow-Credentials' => true,
        'Access-Control-Max-Age' => 3600,
    ],
];
