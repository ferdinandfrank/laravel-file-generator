<?php

namespace FerdinandFrank\LaravelFileGenerator\Console;

use FerdinandFrank\LaravelFileGenerator\StubHelper;

/**
 * ResourceMakeCommand
 * -----------------------
 * Command to create a new API resource.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Console
 */
class ResourceMakeCommand extends \Illuminate\Foundation\Console\ResourceMakeCommand {

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub() {
        return $this->collection() ? StubHelper::find('/resource-collection.stub') : StubHelper::find('/resource.stub');
    }
}
