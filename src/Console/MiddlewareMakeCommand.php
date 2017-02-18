<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * MiddlewareMakeCommand
 * -----------------------
 * Command to create a new middleware class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class MiddlewareMakeCommand extends \Illuminate\Routing\Console\MiddlewareMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/middleware.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.middleware');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}