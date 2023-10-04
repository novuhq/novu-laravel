<?php

namespace Novu\Laravel;

use Novu\SDK\Novu;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Novu\Laravel\Exceptions\ApiKeyIsMissing;


/**
 * Class NovuServiceProvider
 * @package Novu\Laravel
 */
class NovuServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootResources();
        $this->bootDirectives();
        $this->bootComponents();
        $this->bootCommands();
        $this->bootPublishing();
    }

    /**
     * Boot the package resources.
     *
     * @return void
     */
    protected function bootResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'novu');
    }

    /**
     * Boot the package directives.
     *
     * @return void
     */
    protected function bootDirectives()
    {
        Blade::directive(
            'novuJS',
            function () {
                return "<?php echo view('novu::js'); ?>";
            }
        );
    }

    /**
     * Boot the package components.
     *
     * @return void
     */
    protected function bootComponents()
    {
        Blade::component('novu::components.nc', $this->getComponentName('notification-center'));
    }
    
    protected function getComponentName($componentName) 
    {
       if( (int)$this->app->version()[0] <= 6 ) {
          $componentName = str_replace("-", "_", $componentName);
       }
        
       return $componentName;
    }

    protected function bootCommands()
    {
        /**
         * Register Novu Laravel Artisan commands
         */
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                ]
            );
        }
    }

    /**
     * Boot the package's publishable resources.
     *
     * @return void
     */
    protected function bootPublishing()
    {
        if ($this->app->runningInConsole()) {
            $config = dirname(__DIR__) . '/config/novu.php';

            $this->publishes(
                [
                    $config => $this->app->configPath('novu.php'),
                ],
                'novu-laravel-config'
            );
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register the service the package provides.
        $this->app->singleton(
            'novu',
            function ($app) {
                $apiKey = config('novu.api_key');
                $baseUri = config('novu.api_url');

                if (! is_string($apiKey)) {
                    throw ApiKeyIsMissing::create();
                }

                if (is_string($baseUri)) {
                    $config['apiKey'] = $apiKey;
                    $config['baseUri'] = $baseUri;
                    return new Novu($config);
                }

                return new Novu($apiKey);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['novu'];
    }
}
