<?php

namespace FerdinandFrank\LaravelFileGenerator\Providers;

/**
 * ConsoleSupportServiceProvider
 * -----------------------
 * Provides the console commands to the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Providers
 */
class ConsoleSupportServiceProvider extends \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider {

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
        'Illuminate\Console\ScheduleServiceProvider',
        'Illuminate\Database\MigrationServiceProvider',
        'Illuminate\Database\SeedServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
    ];

}