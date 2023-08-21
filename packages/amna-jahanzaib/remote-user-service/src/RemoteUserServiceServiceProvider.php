<?php

namespace AmnaJahanzaib\RemoteUserService;

use Illuminate\Support\ServiceProvider;

class RemoteUserServiceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'amna-jahanzaib');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'amna-jahanzaib');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/remote-user-service.php', 'remote-user-service');

        // Register the service the package provides.
        $this->app->singleton('remote-user-service', function ($app) {
            return new RemoteUserService;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['remote-user-service'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/remote-user-service.php' => config_path('remote-user-service.php'),
        ], 'remote-user-service.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/amna-jahanzaib'),
        ], 'remote-user-service.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/amna-jahanzaib'),
        ], 'remote-user-service.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/amna-jahanzaib'),
        ], 'remote-user-service.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
