<?php

namespace FerdinandFrank\LaravelFileGenerator\Providers;

use FerdinandFrank\LaravelFileGenerator\MigrationCreator;

/**
 * MigrationServiceProvider
 * -----------------------
 * Provides the necessary migration settings to the application.
 *
 * @author Ferdinand Frank
 */
class MigrationServiceProvider extends \Illuminate\Database\MigrationServiceProvider {

    /**
     * Register the migration creator.
     *
     * @return void
     */
    protected function registerCreator() {
        $this->app->singleton('migration.creator', function ($app) {
            return new MigrationCreator($app['files']);
        });
    }
}