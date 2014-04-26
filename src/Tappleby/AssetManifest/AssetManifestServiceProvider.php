<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 9:59 PM
 */

namespace Tappleby\AssetManifest;


use Illuminate\Support\ServiceProvider;

class AssetManifestServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('tappleby/laravel-asset-manifest');

		// Override the default url generator.
		$this->app['url'] = $this->app->share(function($app)
		{
			// The URL generator needs the route collection that exists on the router.
			// Keep in mind this is an object, so we're passing by references here
			// and all the registered routes will be available to the generator.
			$routes = $app['router']->getRoutes();
			$request = $app->rebinding('request', function($app, $request) {
					$app['url']->setRequest($request);
				});

			$assetManifest = $app['asset.manifest'];

			return new AssetUrlGenerator($routes, $request, $assetManifest);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('asset.manifest', function ($app) {
			$storagePath = $app['config']->get('laravel-asset-manifest::manifest_file', null);

			return new AssetManifest($storagePath, $app['files']);
		});
	}

} 