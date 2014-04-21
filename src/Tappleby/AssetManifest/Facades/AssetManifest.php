<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 11:41 PM
 */

namespace Tappleby\AssetManifest\Facades;


use Illuminate\Support\Facades\Facade;

class AssetManifest extends Facade {
	protected static function getFacadeAccessor()
	{
		return 'asset.manifest';
	}
}