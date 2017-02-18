<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * RequestMakeCommand
 * -----------------------
 * Command to create a new request class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class RequestMakeCommand extends \Illuminate\Foundation\Console\RequestMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('model')) {
            return StubHelper::find('/request.stub');
        }

        return StubHelper::find('/request.plain.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.request');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function buildClass($name) {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string $stub
     * @param  string $model
     *
     * @return string
     */
    protected function replaceModel($stub, $model) {
        $model = str_replace('/', '\\', $model);

        $properties = '';
        if (class_exists($model)) {
            $instance = new $model();
            $attributes = $instance->getFillable();
            foreach ($attributes as $attribute) {
                $properties .= "'$attribute' => '',\r\n\t\t\t";
            }
            $properties = rtrim($properties, ',');
        }

        $stub = str_replace('dummyModelProperties', $properties, $stub);
        $stub = str_replace('dummyModel', Str::camel(class_basename($model)), $stub);

        return $stub;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the request applies to.'],
        ];
    }
}