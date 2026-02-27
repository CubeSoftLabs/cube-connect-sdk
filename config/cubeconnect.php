<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your CubeConnect API key. Generate one from the dashboard:
    | Settings > API Keys
    |
    */

    'api_key' => env('CUBECONNECT_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The CubeConnect API base URL. Override for staging/testing environments.
    |
    */

    'base_url' => env('CUBECONNECT_URL', 'https://cubeconnect.io'),

    /*
    |--------------------------------------------------------------------------
    | Tenant ID
    |--------------------------------------------------------------------------
    |
    | Optional. Required only if your API key has access to multiple tenants.
    |
    */

    'tenant_id' => env('CUBECONNECT_TENANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum time in seconds to wait for an API response.
    |
    */

    'timeout' => env('CUBECONNECT_TIMEOUT', 30),

];
