<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * EventGenerateCommand
 * -----------------------
 * Command to automatically generate event classes and their listeners as specified in the EventServiceProvider.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class EventGenerateCommand extends \Illuminate\Foundation\Console\EventGenerateCommand {

    /**
     * Make the event and listeners for the given event.
     *
     * @param  string $event
     * @param  array  $listeners
     *
     * @return void
     */
    protected function makeEventAndListeners($event, $listeners) {
        if (!Str::contains($event, '\\')) {
            return;
        }

        $arguments = ['name' => $event];

        if ($this->option('models')) {

            // Get the model name by the event class name with the following schema 'Post' for the event 'PostCreated'
            $eventPathParts = explode("\\", $event);
            $eventName = $eventPathParts[sizeof($eventPathParts) - 1];
            $modelName = preg_split('/(?=[A-Z])/', $eventName)[1];

            // Only execute with model option, if the model does really exist
            $rootNamespace = trim($this->laravel->getNamespace(), '\\');
            $namespace = $rootNamespace . config('laravel-file-generator.namespaces.model') . '\\';
            if (class_exists($namespace.$modelName)) {
                $arguments['--model'] = $modelName;
            }
        }

        $this->callSilent('make:event', $arguments);

        $this->makeListeners($event, $listeners);
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
                'models',
                'm',
                InputOption::VALUE_NONE,
                'Generate the event classes using the models corresponding to the event class names'
            ]
        ]);
    }
}