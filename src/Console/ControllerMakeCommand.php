<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Symfony\Component\Console\Input\InputOption;

/**
 * ControllerMakeCommand
 * -----------------------
 * Command to create a new controller class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ControllerMakeCommand extends \Illuminate\Routing\Console\ControllerMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('implement')) {
            return StubHelper::find('/controller.implement.stub');
        } elseif ($this->option('model')) {
            return StubHelper::find('/controller.model.stub');
        } elseif ($this->option('resource')) {
            return StubHelper::find('/controller.stub');
        }

        return StubHelper::find('/controller.plain.stub');
    }

    /**
     * Build the class with the given name.
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function buildClass($name) {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        $model = $this->option('implement') ?? $this->option('model');

        if ($model) {
            $modelClass = $this->parseModel($model);

            $replace = [
                'DummyFullModelClass' => $modelClass,
                'DummyModelClass'     => class_basename($modelClass),
                'DummyModelVariable'  => lcfirst(class_basename($modelClass)),
                'DummyModelPlural'    => str_plural(lcfirst(class_basename($modelClass))),
            ];
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        $options = parent::getOptions();

        return array_merge($options, [
            [
                'implement',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Generate an implemented controller for the given model.'
            ]
        ]);
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.controller');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }
}