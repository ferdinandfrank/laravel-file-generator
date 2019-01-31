<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * ModelMakeCommand
 * -----------------------
 * Command to create a new model class.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ModelMakeCommand extends \Illuminate\Foundation\Console\ModelMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return StubHelper::find('/model.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) {
        $namespace = config('laravel-file-generator.namespaces.model');

        return $namespace ? $rootNamespace . $namespace : parent::getDefaultNamespace($rootNamespace);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() {
        if (parent::handle() === false) {
            return false;
        }

        if ($this->option('all')) {
            $this->input->setOption('policy', true);
            $this->input->setOption('api', true);
        }

        if ($this->option('policy')) {
            $this->createPolicy();
        }

        if ($this->option('api')) {
            $this->createApiResources();
        }
    }

    /**
     * Create a policy class for the model.
     *
     * @return void
     */
    protected function createPolicy() {
        $policy = Str::studly(class_basename($this->argument('name')));

        $this->call('make:policy', [
            'name'    => "{$policy}Policy",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a api resource and a resource collection class for the model.
     *
     * @return void
     */
    protected function createApiResources() {
        $resource = Str::studly(class_basename($this->argument('name')));

        $this->call('make:resource', [
            'name'    => "{$resource}Resource"
        ]);
        $this->call('make:resource', [
            'name'    => "{$resource}ResourceCollection"
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, policy, api resources, factory, and resource controller for the model'],

            ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],

            ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the model'],

            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the model already exists'],

            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],

            ['pivot', null, InputOption::VALUE_NONE, 'Indicates if the generated model should be a custom intermediate table model'],

            ['resource', 'r', InputOption::VALUE_NONE, 'Indicates if the generated controller should be a resource controller'],

            ['policy', 'p', InputOption::VALUE_NONE, 'Create a new policy for the model'],

            ['api', null, InputOption::VALUE_NONE, 'Create a resource and a resource collection file for the model'],
        ];
    }
}