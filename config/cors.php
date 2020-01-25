<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Content-Type', 'X-Requested-By', 'Origin'],
    'allowedMethods' => ['GET','OPTIONS', 'HEAD'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
