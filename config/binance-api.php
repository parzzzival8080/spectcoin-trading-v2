<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binance authentication
    |--------------------------------------------------------------------------
    |
    | Authentication key and secret for Binance API.
    |
     */

    'auth' => [
        'key'        => env('BINANCE_KEY', 'o5VTq8n3xE1GDMGIQ9BPCZsJxKdetf77eEXIhd3fKTF9xSkpSy73POxPhMyEt3Qi'),
        'secret'     => env('BINANCE_SECRET', 'CEE84lNYhjE5AK6joDGxn7CdW8A1JqUTBdmmejNxLLvfmWg97z2GfkFZ9BQenJNr'),
    ],

    /*
    |--------------------------------------------------------------------------
    | API URLs
    |--------------------------------------------------------------------------
    |
    | Binance API endpoints
    |
     */

    'urls' => [
        'api'   => 'https://api.binance.com/api/',
        'sapi'  => 'https://api.binance.com/sapi/',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Settings
    |--------------------------------------------------------------------------
    |
    | Binance API settings
    |
     */

    'settings' => [
        'timing' => env('BINANCE_TIMING', 5000),
    ],

];
