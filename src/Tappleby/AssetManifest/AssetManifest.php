<?php
/*
 * User: tappleby
 * Date: 2014-03-23
 * Time: 9:45 PM
 */

namespace Tappleby\AssetManifest;


use Illuminate\Filesystem\Filesystem;

class AssetManifest {
	protected $manifest;
	protected $files;

	function __construct($manifest=null, Filesystem $fs)
	{
		$this->manifest = array();
		$this->files = $fs;

		if (is_string($manifest)) {
			$this->load($manifest);
		} else if (is_array($manifest)) {
			$this->manifest = $manifest;
		}
	}

	public function load($manifestFile) {
		if($this->files->exists($manifestFile)) {
			$data = $this->files->get($manifestFile);
			$this->manifest = json_decode($data, true);
		}
	}

	public function contains($asset) {
		return isset($this->manifest[$asset]);
	}

	public function all() {
		return $this->manifest;
	}

	public function get($asset) {
		if(!$this->contains($asset)) {
			throw new NotFoundException('Could not find asset '.$asset);
		}

		return $this->manifest[$asset];
	}
}
