<?php

namespace Helaplus\Laravelmifos;

use Helaplus\Laravelmifos\Providers\UssdEventServiceProvider;
use Illuminate\Support\ServiceProvider;

class LaravelmifosServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'helaplus');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'helaplus');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
 
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelmifos.php', 'laravelmifos');

        // Register the service the package provides.
        $this->app->singleton('laravelmifos', function ($app) {
            return new Laravelmifos;
        });
        $this->app->register(UssdEventServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelmifos'];
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
            __DIR__.'/../config/laravelmifos.php' => config_path('laravelmifos.php'),
        ], 'laravelmifos.config');

        // Publishing the listeners.
        $this->publishes([
            __DIR__.'/Listeners/UssdEventListener.php' => base_path('app/Listeners/UssdEventListener.php'),
        ], 'UssdEventListener');
        //Publishing the providers
        $this->publishes([
            __DIR__.'/Providers/UssdEventServiceProvider.php' => base_path('app/Providers/UssdEventServiceProvider.php'),
        ], 'UssdEventListener');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/helaplus'),
        ], 'laravelmifos.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/helaplus'),
        ], 'laravelmifos.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/helaplus'),
        ], 'laravelmifos.views');*/

        // Registering package commands.
        // $this->commands([]);
    } 
}
