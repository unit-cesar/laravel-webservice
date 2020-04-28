<?php

return [

    /*
     * You can enable CORS for 1 or multiple paths.
     * Example: ['api/*']
     */
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => false,
    'max_age' => false,
    'supports_credentials' => true,

    // Archive
    // 'allowedMethods' => ['*'],
    // 'allowedOrigins' => ['*'],
    // 'allowedOriginsPatterns' => [],
    // 'allowedHeaders' => ['*'],
    // 'exposedHeaders' => [],
    // 'maxAge' => 0,
    // 'supportsCredentials' => true,

];
