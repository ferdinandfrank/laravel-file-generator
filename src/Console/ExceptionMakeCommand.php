<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * ExceptionMakeCommand
 * -----------------------
 * Command to create a new exception class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ExceptionMakeCommand extends \Illuminate\Foundation\Console\ExceptionMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('render')) {
            return $this->option('report')
                ? StubHelper::find('/exception-render-report.stub')
                : StubHelper::find('/exception-render.stub');
        }

        return $this->option('report')
            ? StubHelper::find('/exception-report.stub')
            : StubHelper::find('/exception.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.exception');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}