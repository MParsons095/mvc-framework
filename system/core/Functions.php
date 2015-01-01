<?php
/**
 *----------------------------------------
 * LOAD CLASS
 *----------------------------------------
 */
function load_class($class,$dir)
{
	//store class instances
	static $loadedClasses = array();

	//class name with namespace
	$className = '';
	$dirPath = '';
	foreach(explode('/',$dir . '/' . $class) AS $partial)
	{
		$dirPath[] = lcfirst($partial);
		$className[] = ucfirst($partial);
	}
	$extension = $className[count($className) - 2];
	$className = implode('\\', $className);
    
    if(count($dirPath) > 1)
    {
    	unset($dirPath[count($dirPath) - 1]);
    	$dirPath = array_values($dirPath);
	}
    
    $dirPath = implode('/', $dirPath);
	switch($extension)
	{
		case 'Helper':
			$extension = '.class';
			break;
		case 'ClassInterface':
			$extension = '.interface';
			break;
		default:
			$extension = '';
			break;
	}

	//path the class file
	$path = SERVER_ROOT . $dirPath . '/' . $class . $extension . '.php';

	//does an instance of the class already exist?
	//if so, return the instance
	if(isset($loadedClasses[$class]))
	{
		return $loadedClasses[$class];
	}

	try
	{
		//does the file exist?
		if(!file_exists($path) || !is_file($path))
		{
        	debug_trace();
			throw new Exception('Class file not found for class "' . $class . '" at ' . $path);
		}

		require_once($path);

		//does the class exist within the file?
		if(!class_exists($className))
		{
			throw new Exception('Class "' . $className . '" not found in file: ' . $path);
		}

		//log the class as "loaded"
		class_loaded($class);

		//store the instance
		$loadedClasses[$class] = new $className();

		return $loadedClasses[$class];
	}
	catch(Exception $e)
	{
		log_internal_error($e);
		load_internal_error('A required file is missing or misconfigured.');
	}
}


function class_loaded($class)
{
	static $isLoaded = array();

	$isLoaded[$class] = $class;

	return $isLoaded;
}



/**
 *----------------------------------------
 * CONFIGURATION SETTINGS
 *----------------------------------------
 */
function load_config_settings()
{
	$filePath = APP_PATH . '/config/options.php';

	try
	{
		if(!file_exists($filePath))
		{
			throw new Exception('Configuration file could not be found at ' . $filePath);
		}

		require $filePath;

		if(!isset($config) || !is_array($config))
		{
			throw new Exception('Configuration array not found');
		}

		return $config;
	}
	catch(Exception $e)
	{
		log_internal_error($e);
		load_internal_error('Failed to load site configuration.');
	}
}


/**
 *----------------------------------------
 * DEBUGGING
 *----------------------------------------
 */
function debug_dump($var)
{
	if(APP_ENVIRONMENT == 'development')
    {
		print '<pre>';
		var_dump($var);
		print '</pre>';
    }
}

function debug_trace($exitProgram = true)
{
	if(APP_ENVIRONMENT == 'development')
    {
		print '<pre>';
		print debug_print_backtrace();
		print '</pre>';
	
	$trace = debug_backtrace();
    }
	log_debug($trace);

	if($exitProgram)
	{
		exit();
	}
}



/**
 *----------------------------------------
 * LOGGING
 *----------------------------------------
 */

//internal errors (exceptions)
function log_internal_error($e,array $data = array())
{
	$string = date('m/d/y') . " at " . date('g:i:s') . "\n";
	$string .= 'Message: ' . $e->getMessage() . "\n";
	$string .= 'Code: ' . $e->getCode() . "\n";
	$string .= 'File: ' . $e->getFile() . "\n";
	$string .= 'Line: ' . $e->getLine() . "\n";

	if($data)
	{
		foreach($data AS $key => $value)
		{
			$string .= $key . ': ' . $value . "\n";
		}
	}

	$string .= "\n\n";
	submitLog(SYSTEM_PATH . 'log/internal_error.txt',$string);
}


//event logger
function log_event($event, $file = '--', $line = '--')
{
	$string = date('m/d/y') . " at " . date('g:i:s') . "\n";
	$string .= 'Event: ' . $event . "\n";
	$string .= 'File: ' . $file . "\n";
	$string .= 'Line: ' . $line . "\n";
	$string .= "\n\n";

	submitLog(SYSTEM_PATH . 'log/event.txt',$string);
}


//runtime error logger
function log_runtime_error($error, $file = '--', $line = '--')
{
	$string = date('m/d/y') . " at " . date('g:i:s') . "\n";
	$string .= 'Error: ' . $error . "\n";
	$string .= 'File: ' . $file . "\n";
	$string .= 'Line: ' . $line . "\n";
	$string .= "\n\n";

	submitLog(SYSTEM_PATH . 'log/runtime_error.txt',$string);
}


//debug logger
function log_debug($trace)
{
	$string = date('m/d/y') . " at " . date('g:i:s') . "\n";
	$string .= $trace;
	$string .= '------------------------------------------------------------------------' . "\n\n";

	submitLog(SYSTEM_PATH . 'log/debug_log.txt',$string);
}


function submitLog($logPath,$data)
{
	if(!file_exists(dirname($logPath)))
	{
		mkdir(dirname($logPath), 0777, true);
		$fp = @fopen($logPath,"x");
		fwrite($fp,$data);
		fclose($fp);
	}
	else
	{
		error_log($data,3,$logPath);
	}
}



/**
 *----------------------------------------
 * ERROR PAGES
 *----------------------------------------
 */

// load 404 page
function load_404()
{
	include APP_PATH . 'error/404_error.php';
	exit();
}

// load internal error page
function load_internal_error($error)
{
	include APP_PATH . 'error/internal_error.php';
	exit();
}