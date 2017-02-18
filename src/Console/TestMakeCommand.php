<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * TestMakeCommand
 * -----------------------
 * Command to create a new test class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class TestMakeCommand extends \Illuminate\Foundation\Console\TestMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/test.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.test');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}