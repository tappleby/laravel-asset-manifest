<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 10:17 PM
 */
namespace Tappleby\AssetManifest;

use \Mockery as m;

class AssetManifestTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorCallsLoadWithNullManifest()
	{
		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$fs->shouldReceive('exists')->once()->andReturn(false);

		new AssetManifest(null, $fs);
	}

	public function testConstructorDoesNotLoadManifestWhenGivenArray() {
		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$fs->shouldReceive('exists')->never();

		new AssetManifest(array(), $fs);
	}

	public function testLoadChecksFileExists() {
		$filename = 'foo.bar';
		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$fs->shouldReceive('exists')->once()->with($filename)->andReturn(false);
		$fs->shouldReceive('get')->never();

		$am = new AssetManifest(array(), $fs);
		$am->load($filename);
	}

	public function testLoad() {
		$filename = 'foo.bar';
		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$fs->shouldReceive('exists')->once()->with($filename)->andReturn(true);
		$fs->shouldReceive('get')->once()->with($filename)->andReturn('{ "foo": "bar" }');

		$am = new AssetManifest(array(), $fs);
		$am->load($filename);

		$manifest = $am->all();

		$this->assertArrayHasKey('foo', $manifest);
		$this->assertEquals('bar', $manifest['foo']);
	}

	/**
	 * @expectedException     \Tappleby\AssetManifest\NotFoundException
	 */
	public function testGetThrowsExceptionOnMissing()
	{
		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$am = new AssetManifest(array(), $fs);

		$am->get('foo');
	}

	public function testGetReturnsManifestValue()
	{

		$fs = m::mock('Illuminate\Filesystem\Filesystem');
		$am = new AssetManifest(array('foo' => 'bar'), $fs);

		$result = $am->get('foo');

		$this->assertEquals('bar', $result);
	}


}
 