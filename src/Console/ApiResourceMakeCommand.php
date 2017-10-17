<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

/**
 * ApiResourceMakeCommand
 * -----------------------
 * Command to create a new API resource.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ApiResourceMakeCommand extends \Illuminate\Foundation\Console\ResourceMakeCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:api-resource';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return $this->collection()
            ? StubHelper::find('/api-resource-collection.stub')
            : StubHelper::find('/api-resource.stub');
    }
}
