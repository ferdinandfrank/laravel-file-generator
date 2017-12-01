<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

/**
 * ResourceMakeCommand
 * -----------------------
 * Command to create a new controller class, policy class and a request class for a specified model as well as a new
 * model class on demand.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ResourceMakeCommand extends GeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class, controller class, policy class and a request class for the specified name.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ResourceController';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/resource.stub');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The full name of the model (including the namespace) to generate the classes for.'
            ],
        ];
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput() {
        return trim($this->argument('name')) . 'Controller';
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function qualifyClass($name) {
        $defaultNamespace = $this->getDefaultNamespace(trim($this->rootNamespace(), '\\'));

        if (Str::startsWith($name, $defaultNamespace)) {
            return $name;
        }

        $name = class_basename($name);

        return $this->qualifyClass($defaultNamespace . '\\' . $name);
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

        $fullModelClass = $this->parseModel($this->argument('name'));
        if (!class_exists($fullModelClass)) {
            $this->call('make:model', ['name' => $fullModelClass]);
        } else {
            $this->info("The model {$fullModelClass} already exists.");
        }

        $baseModelClass = class_basename($fullModelClass);
        $modelVar = lcfirst($baseModelClass);
        $pluralModelVar = str_plural($modelVar);
        $requestClass = $baseModelClass . 'CreateRequest';
        $policyClass = $baseModelClass . 'Policy';
        $resourceClass = $baseModelClass . 'Resource';
        $resourceCollectionClass = $resourceClass . 'Collection';

        $this->call('make:policy', ['name' => $policyClass, '--model' => $fullModelClass]);
        $this->call('make:request', ['name' => $requestClass, '--model' => $fullModelClass]);
        $this->call('make:api-resource', ['name' => $resourceClass]);
        $this->call('make:api-resource', ['name' => $resourceCollectionClass]);

        // Write routes corresponding to the controller functions
        $webRoutesFile = config('web_routes_file_path', base_path('routes/web.php'));
        $routes = "Route::resource('" . $pluralModelVar . "', '" . class_basename($this->getNameInput()) . "');";
        file_put_contents($webRoutesFile, "\r\n" . $routes, FILE_APPEND);

        $replace = [
            'DummyFullModelClass' => $fullModelClass,
            'DummyModelClass'     => $baseModelClass,
            'DummyModelVariable'  => $modelVar,
            'DummyModelPlural'    => $pluralModelVar,
            'DummyRequestClass'   => $requestClass
        ];

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Gets the fully-qualified model class name.
     *
     * @param $model
     *
     * @return string
     */
    private function parseModel($model) {
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

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.controller');

        return $namespace ? $rootNamespace . $namespace : $rootNamespace . '\Http\Controllers';
    }
}
