<?php namespace System\Core;

use \Exception;

class Config
{
	private $config;


	public function __construct()
	{
		$this->config = load_config_settings();
	}


	public function get($path = '')
	{
		$setting = $this->config;

		//by default, return all configuration settings
		if($path === '')
		{
			return $setting;
		}

		$path = explode('/',$path);

		//search for config setting and return it's value
		try
		{
			foreach($path AS $option)
			{
				if(isset($setting[$option]))
				{
					$setting = $setting[$option];
				}
				else
				{
					throw new Exception('Config setting not found for path: ' . implode('/', $path));
				}
			}

			return $setting;
		}
		catch(Exception $e)
		{
			log_internal_error($e);
			return null;
		}
	}
}