# Laravel File Generator
[![Packagist Version](https://img.shields.io/packagist/v/ferdinandfrank/laravel-file-generator.svg)](https://packagist.org/packages/ferdinandfrank/laravel-file-generator)
[![Packagist](https://img.shields.io/packagist/dt/ferdinandfrank/laravel-file-generator.svg)](https://github.com/ferdinandfrank/laravel-file-generator)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

This package is an easy extension of the Artisan make commands provided by your Laravel application to have the ability to modify the command's stubs 
to your personal needs and to generate fully implemented php classes (controller, requests, policies, etc.) for a specified model.

## Requirements
- [PHP](https://php.net) >=7.0.0
- An existing >= [Laravel 5.5](https://laravel.com/docs/master/installation) project

Note: For Laravel 5.4 see version 1.0

## Installation

1. To get started, install the package via the Composer package manager: 

    ```bash
    composer require ferdinandfrank/laravel-file-generator
    ```
2. Replace the entry ` Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class` within your providers array in `config/app.php`:
 
     ```php
     'providers' => [
        ...
        // Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        FerdinandFrank\LaravelFileGenerator\Providers\ConsoleSupportServiceProvider::class,
        ...
     ]
     ```
   
3. Add the following entry to your providers array in `config/app.php`:
    
    ```php
    'providers' => [
       ...
       ...
       FerdinandFrank\LaravelFileGenerator\Providers\FileGeneratorServiceProvider::class
    ]
    ```

That's it!
    
## Usage
You can use the Artisan make commands provided by your Laravel application like always.
For example, just execute the following command to create a new controller class with the name `UserController`:

    php artisan make:controller UserController
    
For more details as well as a list of all available commands have a look at the [wiki of this package](https://github.com/ferdinandfrank/laravel-file-generator/wiki).    
    
### Publishing stub files    
To have the full benefits of this package you can execute the following command. This will publish all the stub
files which are used to create the php files when executing an Artisan make command.

    php artisan vendor:publish --tag=stubs
    
By default the stub files will be copied to the `resources\stubs` folder of your application. As soon as you call
an Artisan make command after you executed this publishing command for the stubs the stub files for generating
a new php file will be used as the template from this folder. To modify the path to your stubs file have a look
on the next section 'Configuration'.

### Configuration
You have the possibility to modify the path to your stub files as well as other configuration options.
Therefore you need to publish the configuration file of this package by the following command.

    php artisan vendor:publish --tag=config
    
This command will generate the file `laravel-file-generator.php` within your config folder of your Laravel application.

## Commands
You can see all details and documentation about the available make commands on the [wiki of this package](https://github.com/ferdinandfrank/laravel-file-generator/wiki). 

**Important:** Laravel's native command `make:resource` is represented by the command `make:api-resource` in this package.

## License
[MIT](LICENSE)
