<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Path to the stubs file
    |--------------------------------------------------------------------------
    |
    | The path to the folder where the stub files shall be published.
    | Also when calling an Artisan "make" command the stub files from this folder will be used.
    |
    */

    'stubs_path' => resource_path('stubs'),

    /*
    |--------------------------------------------------------------------------
    | Path to the application's web routes file
    |--------------------------------------------------------------------------
    |
    | The path to the web routes file. Necessary for the Artisan "make:resource" command to insert the
    | resource routes to the web routes file.
    |
    */

    'web_routes_file_path' => base_path('routes/web.php'),

    /*
    |--------------------------------------------------------------------------
    | Path to the application's policies provider class
    |--------------------------------------------------------------------------
    |
    | The path to the provider where the policies are registered (usually the "AuthServiceProvider").
    | Used for the Artisan "make:policy" command to register the policy for the corresponding model in the
    | providers array.
    |
    */

    'policies_provider_path' => app_path('Providers/AuthServiceProvider.php'),

    /*
    |--------------------------------------------------------------------------
    | Stub Namespaces
    |--------------------------------------------------------------------------
    |
    | Defines where the created files through an Artisan "make" command shall be saved as well as the namespace
    | of the corresponding entity to use for the generated file.
    |
    */

    'namespaces' => [
        'console'      => '\Console\Commands',
        'controller'   => '\Http\Controllers',
        'event'        => '\Events',
        'job'          => '\Jobs',
        'listener'     => '\Listeners',
        'mail'         => '\Mail',
        'middleware'   => '\Http\Middleware',
        'model'        => '\Models',
        'notification' => '\Notifications',
        'policy'       => '\Policies',
        'provider'     => '\Providers',
        'request'      => '\Http\Requests',
        'seeder'       => '',
        'test'         => ''
    ],
];
