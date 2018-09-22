<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * FactoryMakeCommand
 * -----------------------
 * Command to create a new exception class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class FactoryMakeCommand extends \Illuminate\Database\Console\Factories\FactoryMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/factory.stub');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name) {
        $model = $this->option('model') ? $this->parseModel($this->option('model')) : 'Model';

        $stub = $this->files->get($this->getStub());
        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        return str_replace('DummyModel', $model, $stub);
    }

    /**
     * Gets the fully-qualified model class name.
     *
     * @param $model
     *
     * @return string
     */
    protected function parseModel($model) {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        $rootNamespace = trim($this->rootNamespace(), '\\');
        $namespace = $rootNamespace . config('laravel-file-generator.namespaces.model') . '\\';
        if (!Str::startsWith($model, $namespace)) {
            $model = $namespace . $model;
        }

        return $model;
    }
}