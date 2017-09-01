<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

/**
 * EventMakeCommand
 * -----------------------
 * Command to create a new event class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class EventMakeCommand extends \Illuminate\Foundation\Console\EventMakeCommand {

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        $options = parent::getOptions();

        return array_merge($options, [
            [
                'model',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Generate an implemented event for the given model.'
            ]
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('model')) {
            return StubHelper::find('/event.stub');
        }

        return StubHelper::find('/event.plain.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.event');

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
        $stub = $this->files->get($this->getStub());

        $model = $this->option('model');
        if (!empty($model)) {
            $modelClass = $this->parseModel($model);

            $replace = [
                'DummyFullModelClass' => $modelClass,
                'DummyModelClass'     => class_basename($modelClass),
                'DummyModelVariable'  => lcfirst(class_basename($modelClass))
            ];

            $stub = str_replace(
                array_keys($replace), array_values($replace), $stub
            );
        }

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
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