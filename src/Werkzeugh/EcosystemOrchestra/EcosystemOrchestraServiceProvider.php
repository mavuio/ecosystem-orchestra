<?php namespace Werkzeugh\EcosystemOrchestra;

use Illuminate\Support\ServiceProvider;

class EcosystemOrchestraServiceProvider extends ServiceProvider
{

       /**
	   * Indicates if loading of the provider is deferred.
	   *
	   * @var bool
	   */
       protected $defer = false;

       /**
	   * Register the service provider.
	   *
	   * @return void
	   */
    public function register()
    {


        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('EcoAsset', 'Werkzeugh\Ecosystem\Facades\EcoAssetFacade');
        });

        // register third party service provider
        $this->app->register('Orchestra\Asset\AssetServiceProvider');
        $this->app->register('Werkzeugh\Ecosystem\EcosystemServiceProvider');

        $this->app->bind('Werkzeugh\Ecosystem\ControllerExtensionInterface', function() {
            return new \Werkzeugh\EcosystemOrchestra\ControllerExtension();
        });

        $this->app->bindShared('werkzeugh.ecoasset', function ($app) {
            return new EcoAsset();
        });


    }

       /**
	   * Get the services provided by the provider.
	   *
	   * @return array
	   */
    public function provides()
    {
           return array();
    }



}
