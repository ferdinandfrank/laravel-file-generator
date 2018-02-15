<?php

namespace FerdinandFrank\LaravelFileGenerator\Providers;

use FerdinandFrank\LaravelFileGenerator\Console\ApiResourceMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ControllerMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\EventGenerateCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ObserverMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\PolicyMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ConsoleMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\EventMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\JobMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ListenerMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\MailMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\MiddlewareMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ModelMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\NotificationMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ProviderMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\RequestMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\ResourceMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\SeederMakeCommand;
use FerdinandFrank\LaravelFileGenerator\Console\TestMakeCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;

/**
 * ArtisanServiceProvider
 * -----------------------
 * Provides the necessary artisan commands to the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package FerdinandFrank\LaravelFileGenerator\Providers
 */
class ArtisanServiceProvider extends \Illuminate\Foundation\Providers\ArtisanServiceProvider {

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        'ApiResourceMake'   => 'command.api-resource.make',
        'AppName'           => 'command.app.name',
        'AuthMake'          => 'command.auth.make',
        'CacheTable'        => 'command.cache.table',
        'ConsoleMake'       => 'command.console.make',
        'ControllerMake'    => 'command.controller.make',
        'EventGenerate'     => 'command.event.generate',
        'EventMake'         => 'command.event.make',
        'ExceptionMake'     => 'command.exception.make',
        'FactoryMake'       => 'command.factory.make',
        'JobMake'           => 'command.job.make',
        'ListenerMake'      => 'command.listener.make',
        'MailMake'          => 'command.mail.make',
        'MiddlewareMake'    => 'command.middleware.make',
        'MigrateMake'       => 'command.migrate.make',
        'ModelMake'         => 'command.model.make',
        'NotificationMake'  => 'command.notification.make',
        'ObserverMake'      => 'command.observer.make',
        'NotificationTable' => 'command.notification.table',
        'PolicyMake'        => 'command.policy.make',
        'ProviderMake'      => 'command.provider.make',
        'QueueFailedTable'  => 'command.queue.failed-table',
        'QueueTable'        => 'command.queue.table',
        'RequestMake'       => 'command.request.make',
        'ResourceMake'      => 'command.resource.make',
        'RuleMake'          => 'command.rule.make',
        'SeederMake'        => 'command.seeder.make',
        'SessionTable'      => 'command.session.table',
        'Serve'             => 'command.serve',
        'TestMake'          => 'command.test.make',
        'VendorPublish'     => 'command.vendor.publish'
    ];

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerApiResourceMakeCommand() {
        $this->app->singleton('command.api-resource.make', function ($app) {
            return new ApiResourceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerControllerMakeCommand() {
        $this->app->singleton('command.controller.make', function ($app) {
            return new ControllerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerResourceMakeCommand() {
        $this->app->singleton('command.resource.make', function ($app) {
            return new ResourceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerConsoleMakeCommand() {
        $this->app->singleton('command.console.make', function ($app) {
            return new ConsoleMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEventGenerateCommand() {
        $this->app->singleton('command.event.generate', function () {
            return new EventGenerateCommand;
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEventMakeCommand() {
        $this->app->singleton('command.event.make', function ($app) {
            return new EventMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerJobMakeCommand() {
        $this->app->singleton('command.job.make', function ($app) {
            return new JobMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerListenerMakeCommand() {
        $this->app->singleton('command.listener.make', function ($app) {
            return new ListenerMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMailMakeCommand() {
        $this->app->singleton('command.mail.make', function ($app) {
            return new MailMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMiddlewareMakeCommand() {
        $this->app->singleton('command.middleware.make', function ($app) {
            return new MiddlewareMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateMakeCommand() {
        $this->app->singleton('command.migrate.make', function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['migration.creator'];

            $composer = $app['composer'];

            return new MigrateMakeCommand($creator, $composer);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelMakeCommand() {
        $this->app->singleton('command.model.make', function ($app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerNotificationMakeCommand() {
        $this->app->singleton('command.notification.make', function ($app) {
            return new NotificationMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerObserverMakeCommand() {
        $this->app->singleton('command.observer.make', function ($app) {
            return new ObserverMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerProviderMakeCommand() {
        $this->app->singleton('command.provider.make', function ($app) {
            return new ProviderMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRequestMakeCommand() {
        $this->app->singleton('command.request.make', function ($app) {
            return new RequestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeederMakeCommand() {
        $this->app->singleton('command.seeder.make', function ($app) {
            return new SeederMakeCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerTestMakeCommand() {
        $this->app->singleton('command.test.make', function ($app) {
            return new TestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerPolicyMakeCommand() {
        $this->app->singleton('command.policy.make', function ($app) {
            return new PolicyMakeCommand($app['files']);
        });
    }


}