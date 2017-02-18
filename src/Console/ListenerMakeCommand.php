<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * ListenerMakeCommand
 * -----------------------
 * Command to create a new listener class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ListenerMakeCommand extends \Illuminate\Foundation\Console\ListenerMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('queued')) {
            return StubHelper::find('/listener-queued.stub');
        }

        return StubHelper::find('/listener.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.listener');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}