<?php

class Input
{
	private $path;

	function setPath($path)
	{
		if (empty($path))
			$this->path = "./";
		else $this->path = $path;
	}

	function getPath()
	{
		return $this->path;
	}

}
?>