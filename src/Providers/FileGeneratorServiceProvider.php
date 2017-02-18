<?php

namespace FerdinandFrank\LaravelFileGenerator\Providers;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\ServiceProvider;

/**
 * FileGeneratorServiceProvider
 * -----------------------
 * Provides the publishing command for the "laravel-file-generator" package to publish the config file and the
 * stubs.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Providers
 */
class FileGeneratorServiceProvider extends ServiceProvider {

    /**
     * Path to the config file of the package.
     *
     * @var string
     */
    private $configFilePath = __DIR__ . '/../../config/laravel-file-generator.php';

    /**
     * Path to the stub files folder of the package.
     *
     * @var string
     */
    private $stubsFolderPath = __DIR__ . '/../../resources/stubs/';

    /**
     * Path to the Laravel framework source directory.
     *
     * @var string
     */
    private $frameworkPath = 'vendor/laravel/framework/src/';

    /**
     * Paths to the Laravel framework stub file folders.
     *
     * @var array
     */
    private $frameworkStubPaths = [
        'Illuminate/Database/Console/Seeds/stubs/',
        'Illuminate/Foundation/Console/stubs/',
        'Illuminate/Routing/Console/stubs/',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom($this->configFilePath, 'stubs');
    }

    /**
     * Bootstrapping the service provider.
     *
     * @return void
     */
    public function boot() {
        $this->publishes([
            $this->configFilePath => config_path('laravel-file-generator.php'),
        ], 'config');

        $stubFolder = [];
        $stubOutputPath = StubHelper::getStubsFolderPath();
        $stubFolder[$this->stubsFolderPath] = $stubOutputPath;
        foreach ($this->frameworkStubPaths as $stubPath) {
            $stubFolder[base_path($this->frameworkPath . $stubPath)] = $stubOutputPath;
        }

        $this->publishes($stubFolder, 'stubs');

    }

}