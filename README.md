# Laravel Asset Manifest

Simple Laravel 4 package for re-mapping assets paths, useful for asset revving using tools such as grunt and/or loading assets from a CDN. Extends Laravel's url generator which means existing `asset()` or `URL::asset` calls will work without changes.

[![Build Status](https://travis-ci.org/tappleby/laravel-asset-manifest.svg?branch=master)](https://travis-ci.org/tappleby/laravel-asset-manifest)

## Installation

Require the `tappleby/laravel-asset-manfiest`in your composer.json

	$ composer require tappleby/laravel-asset-manifest:1.*
	
Add the AssetManifestServiceProvider to your `app/config/app.php`:

	'Tappleby\AssetManifest\AssetManifestServiceProvider',

**Optional**

If you wish to access the asset manifest manually, the facade can be registered:

	'AssetManifest'   => 'Tappleby\AssetManifest\Facades\AssetManifest',

The default config path can be changed by publishing the config:

	$ php artisan config:publish tappleby/laravel-asset-manfiest

## Usage

The only requirement of this package is a manifest JSON file located at `app/storage/meta/assets.json`. If a key is found in the JSON file, its value will be used as the new asset path:

	{
		"src": "target",
		"foo.png": "bar.png",
		"baz.png": "//cdn.awesomehost.com/baz.png"
	}

Calling `asset("foo.png")` in your view will return "bar.png". If the target url starts with `http` or `//` this value will be returned without passing through laravels default url generator: `asset("baz.png")` returns `//cdn.awesomehost.com/baz.png`

This package integrates well with grunt + grunt-filerev, using the [grunt-filerev-assets](https://github.com/richardbolt/grunt-filerev-assets) package the asset manfiest can automatically be generated.


## License 

licensed under the MIT License - see the LICENSE file for details