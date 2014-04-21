<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 10:44 PM
 */

namespace Tappleby\AssetManifest;

use \Mockery as m;

class AssetUrlGeneratorTest extends \PHPUnit_Framework_TestCase {

	public function testAssetGeneration()
	{
		$gen = new AssetUrlGenerator(
			$routes = new \Illuminate\Routing\RouteCollection,
			$request = \Illuminate\Http\Request::create('http://foo.com/'),
			$manifest = m::mock('Tappleby\AssetManifest\AssetManifest')
		);

		$manifest->shouldReceive('contains')->with('foo')->andReturn(false);
		$manifest->shouldReceive('contains')->with('bar')->andReturn(true);
		$manifest->shouldReceive('get')->with('bar')->andReturn('baz');

		$url = $gen->asset('foo');
		$this->assertEquals('http://foo.com/foo', $url);

		$url = $gen->asset('bar');
		$this->assertEquals('http://foo.com/baz', $url);
	}

	public function testAssetGenerateSupportsManifestHttpUrls()
	{
		$gen = new AssetUrlGenerator(
			$routes = new \Illuminate\Routing\RouteCollection,
			$request = \Illuminate\Http\Request::create('http://foo.com/'),
			$manifest = m::mock('Tappleby\AssetManifest\AssetManifest')
		);

		$manifest->shouldReceive('contains')->with('fiz')->andReturn(true);
		$manifest->shouldReceive('get')->with('fiz')->andReturn('http://fiz.com/biz');

		$manifest->shouldReceive('contains')->with('baz')->andReturn(true);
		$manifest->shouldReceive('get')->with('baz')->andReturn('//fiz.com/baz');

		$url = $gen->asset('fiz');
		$this->assertEquals('http://fiz.com/biz', $url);

		$url = $gen->asset('baz');
		$this->assertEquals('//fiz.com/baz', $url);
	}


}
 