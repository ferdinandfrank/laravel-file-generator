<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * ObserverMakeCommand
 * -----------------------
 * Command to create a new observer class for a specified model.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ObserverMakeCommand extends GeneratorCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new observer class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Observer';

    /**
     * Determine if the class already exists.
     *
     * @param  string $rawName
     *
     * @return bool
     */
    protected function alreadyExists($rawName) {
        return class_exists($rawName);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [[
            'model',
            'm',
            InputOption::VALUE_OPTIONAL,
            'Generate an observer for the given model'
        ]];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('model')) {
            return StubHelper::find('/observer.stub');
        }

        return StubHelper::find('/observer.plain.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.observer');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle() {
        $this->info('Trying to create a Service Provider to register the ' . $this->type . '.');
        $this->call('make:provider', [
            'name'    => $this->type . 'ServiceProvider'
        ]);

        return parent::handle();
    }

    /**
     * Insert arbitrary text into any place inside a text file
     *
     * @param string $file_path - absolute path to the file
     * @param string $insert_marker - a marker inside the file to
     *                              look for as a pattern match
     * @param string $text - text to be inserted
     */
    private function insertIntoFile($file_path, $insert_marker, $text) {
        $contents = file_get_contents($file_path);
        $new_contents = str_replace($insert_marker, $text, $contents);

        if (file_put_contents($file_path, $new_contents) > 0) {
            $this->info("Successfully wrote new content into $file_path.");
        }
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

//            $this->info("Trying to register $name.");
//            $insertString = "$modelClass::observe($name::class);";
//            $observerProviderFile = app_path('Providers/'.$this->type.'ServiceProvider.php');
//            $insert_marker = "public function boot()
//    {";
//            $this->insertIntoFile($observerProviderFile, $insert_marker, "$insert_marker\r\n\t\t$insertString");
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