<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 9:54 PM
 */

namespace Tappleby\AssetManifest;


use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Symfony\Component\HttpFoundation\Request;

class AssetUrlGenerator extends UrlGenerator {
	protected $manifest;

	public function __construct(RouteCollection $routes, Request $request, AssetManifest $manifest)
	{
		parent::__construct($routes, $request);

		$this->manifest = $manifest;
	}

	public function asset($path, $secure = null)
	{
		if($this->manifest->contains($path)) {
			$path = $this->manifest->get($path);

			if( strpos($path, 'http') === 0 || strpos($path, '//') ) {
				return $path;
			}
		}

		return parent::asset($path, $secure);
	}
}