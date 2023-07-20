<?php

/*
 * This file is part of the Novu Laravel package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Novu API Key
    |--------------------------------------------------------------------------
    |
    | The Novu API key give you access to Novu's API. The "api_key" is
    | typically used to make a request to the API.
    |
    */
    'api_key' => env('NOVU_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | The Novu API Base URL.
    |--------------------------------------------------------------------------
    |
    | The Novu API Base URL can be a self-hosted novu api or Novu's web cloud API
    | typically used to make a request to Novu's service.
    |
    */
    'api_url' => env('NOVU_BASE_API_URL', 'https://api.novu.co/v1/'),
];
