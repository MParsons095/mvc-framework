<?php namespace System\Core;

use \Exception;

class Loader
{
	protected $controllerInstance;
	protected $modelList = array();
	protected $modelPath;
	protected $domainObjectList = array();
	protected $domainObjectPath;
	protected $mapperList = array();
	protected $mapperPath;
	protected $libraryList = array();
	protected $libraryPath;


	public function __construct()
	{
		$this->modelPath = APP_PATH . 'model/';
		$this->mapperPath = APP_PATH . 'mapper/';
		$this->domainObjectPath = APP_PATH . '/domainObject/';
		$this->libraryPath = SYSTEM_PATH . '/library/';
	}


	public function setInstance(Controller $c)
	{
		$this->controllerInstance = $c;
	}


	public function model($model)
	{
		$this->addObject($model,'model','model');
	}


	public function mapper($mapper)
	{
		$this->addObject($mapper,'mapper','mapper');
	}


	public function domainObject($object)
	{
		$this->addObject($object,'domainObject','object');
	}


	public function library($object)
	{
		$this->addObject($object,'library');
	}


	private function addObject($object,$type,$extension = '')
	{
		$extension = ucfirst($extension);
		$path = $type . 'Path';
		$path = $this->$path . $object . $extension . '.php';

		try
		{
			if(!is_file($path))
			{
				throw new Exception('The ' . $type . ' class file for ' . $object . ' could not be found at ' . $path);
			}

			$list = $type . 'List';
			$this->{$list}[] = $object;
			$object .= $extension;
			$objectName = '\Application\\' . ucfirst($type) . '\\' . ucfirst($object);

			if(class_exists($objectName))
			{
				$this->controllerInstance->$object = new $objectName;
			}
			else
			{
				log_runtime_error('Class ' . $objectName . ' not found in file: ' . $path,'Loader.php::addObject()','81');
				load_internal_error('Required page component not found');
			}
		}
		catch(Exception $e)
		{
			log_internal_error($e);
			load_internal_error('Required File Missing');
		}
	}
}