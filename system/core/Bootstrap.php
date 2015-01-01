<?php
/**
 *----------------------------------------
 * LOAD REQUIRED FILES
 *----------------------------------------
 */

//autoloader
require SYSTEM_PATH . 'core/Autoload.php';

//global functions
require SYSTEM_PATH . 'core/Functions.php';

//configuration options
require APP_PATH . 'config/options.php';


/**
 *----------------------------------------
 * LOAD AND STORE INSTANCES OF REQUIRED CLASSES
 *----------------------------------------
 */

//Config Class
$Config = load_class('Config','system/core');

//URI Class
$URI = load_class('URI','system/core');

//Router Class
$Router = load_class('Router','system/core');

//Session Class
$Session = load_class('Session','system/library');


/**
 *----------------------------------------
 * START SESSION
 *----------------------------------------
 */
$Session->start();


/**
 *----------------------------------------
 * LOAD CONTROLLER AND METHOD
 *----------------------------------------
 */
$Router->getRoute();

//load controller
$controllerPath = APP_PATH . 'controller/' . $Router->getController() . 'Controller.php';
$Controller = 'Application\Controller\\' . $Router->getController() . 'Controller';

if(is_file($controllerPath))
{
	$Controller = new $Controller();
}
else
{
	load_404();
}

//load method
$method = str_replace('-', '_', $Router->getMethod());
$params = $Router->getParams();

if(!method_exists($Controller, $method))
{
	load_404();
}

$ReflectMethod = new ReflectionMethod($Controller, $method);

if($ReflectMethod->getNumberOfRequiredParameters() > 0 && $ReflectMethod->getNumberOfRequiredParameters() != intval($params))
{
	load_404();
}

if(count($ReflectMethod->getParameters()) > 0)
{
	$ReflectMethod->invokeArgs($Controller, $params);
	return;
}

//if no parameters are required, call the method
$Controller->{$method}();