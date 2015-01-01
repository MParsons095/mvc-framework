<?php namespace System\Core;

class URI
{
	private $uri;
	private $segments;


	public function __construct()
	{
		$this->validate = load_class('Validator','System/Helper');

		$this->setUri();
		$this->setSegments();
	}


	public function setUri()
	{
		$this->uri = $this->removeSlashes($_SERVER['REQUEST_URI']);
	}


	public function getUri()
	{
		return $this->uri;
	}


	public function setSegments()
	{
		$this->segments = $this->parseUri();
	}


	public function getSegments()
	{
		return $this->segments;
	}


	public function getSingleSegment($index)
	{
		if(isset($this->segments[$index]))
		{
			return $this->segments[$index];
		}

		return false;
	}


	/**
	 *	Remove extra slashes from url
	 *		#example:	http://mywebsite.com/index//page///	->	http://mywebsite.com/index/page
	 *	@return String;
	 */
	private function removeSlashes($url)
	{
		//remove extra slashes in between url
		$url = str_replace('//','/',$url);
		
		//remove trailing slash
		while(substr($url, -1) === '/')
		{
			$url = substr($url,0,-1);
		}
		
		//remove starting slashes
		while(substr($url, 0,1) === '/')
		{
			$url = substr($url,1);
		}

		return $url;
	}


	private function parseUri()
	{
		$segments = explode('/',$this->uri);
		unset($segments[0]);
		
		return array_values($segments);
	}


	/**
	 *	Validate each part of the url
	 *	@return boolean
	 */
	private function validateURLSegments($segments)
	{
		$is_valid = true;

		foreach ($segments as $key => $value)
		{
			$is_valid &= $this->Validator->validate($value,'urlParam');
		}

		if(!$is_valid)
		{
			load_404();
		}

		return true;
	}
}