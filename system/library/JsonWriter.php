<?php namespace System\Library;

use \System\ClassInterface\Writer;

class JsonWriter implements Writer
{
	public function write($data)
	{
		print json_encode($data);
	}
}