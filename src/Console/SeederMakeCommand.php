<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * SeederMakeCommand
 * -----------------------
 * Command to create a new seeder class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class SeederMakeCommand extends \Illuminate\Database\Console\Seeds\SeederMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/seeder.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.seeder');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}