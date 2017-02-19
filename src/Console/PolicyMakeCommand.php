<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\Str;

/**
 * PolicyMakeCommand
 * -----------------------
 * Command to create a new policy class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class PolicyMakeCommand extends \Illuminate\Foundation\Console\PolicyMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        if ($this->option('model')) {
            return StubHelper::find('/policy.stub');
        }

        return StubHelper::find('/policy.plain.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.policy');

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
        $model = $this->option('model');
        if (!empty($model)) {
            $policy = "\\$model::class => \\$name::class,";
            $authProviderFile = config('policies_provider_path', app_path('Providers/AuthServiceProvider.php'));
            $insert_marker = 'protected $policies = [';
            $this->insertIntoFile($authProviderFile, $insert_marker, "$insert_marker\r\n\t\t$policy");
        }

        return parent::buildClass($name);
    }

    /**
     * Insert arbitrary text into any place inside a text file
     *
     * @param string $file_path - absolute path to the file
     * @param string $insert_marker - a marker inside the file to
     *                              look for as a pattern match
     * @param string $text - text to be inserted
     *
     * @return integer - the number of bytes written to the file
     */
    private function insertIntoFile($file_path, $insert_marker, $text) {
        $contents = file_get_contents($file_path);
        $new_contents = str_replace($insert_marker, $text, $contents);

        return file_put_contents($file_path, $new_contents);
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

        if (!Str::startsWith($model, $this->laravel->getNamespace())) {
            $stub = str_replace('NamespacedDummyModel', $this->laravel->getNamespace() . $model, $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        }

        $model = class_basename(trim($model, '\\'));

        $stub = str_replace('DummyModel', $model, $stub);

        if ($model == 'User') {
            $stub = str_replace('use UserModelNamespace;', '', $stub);
        } else {
            $userNamespace = str_replace('/', '\\', 'App' . config('laravel-file-generator.namespaces.model', '\\') . 'User');
            $stub = str_replace('UserModelNamespace', $userNamespace, $stub);
        }


        $stub = str_replace('dummyModel', Str::camel($model), $stub);

        return str_replace('dummyPluralModel', Str::plural(Str::camel($model)), $stub);
    }
}