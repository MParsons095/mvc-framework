<?php
/**
 *----------------------------------------
 * APPLICATION ENVIRONMENT
 *----------------------------------------
 *
 *	Accepted Values:
 *		- development
 *		- production
 *
 *	The application environment constant will affect
 *	error reporting and logging.
 */
define('APP_ENVIRONMENT','development');

/**
 *----------------------------------------
 * SET ERROR REPORTING AND LOGGING
 *----------------------------------------
 */
if(defined('APP_ENVIRONMENT'))
{
	switch(APP_ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
			break;
	case 'production':
			error_reporting(0);
			break;
	default:
		exit('Invalid environment state.');
	}
}



/**
 *----------------------------------------
 * DEFAULT PATHS
 *----------------------------------------
 */

//Server Root
$serverPath = $_SERVER['DOCUMENT_ROOT'];
$serverPathDelimiterOffset = 0;

if(substr($serverPath, -1) == '/')
{
	$serverPathDelimiterOffset = 1;
}

define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'] . substr(dirname($_SERVER['PHP_SELF']),$serverPathDelimiterOffset) . '/');

//Domain Root
define('DOMAIN_ROOT','http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');

//Application Folder
define('APP_PATH', SERVER_ROOT . 'application/');

//System Folder
define('SYSTEM_PATH', SERVER_ROOT . 'system/');

//Public Folder
define('PUBLIC_PATH', SERVER_ROOT . 'public/');

/**
 *----------------------------------------
 * LOAD BOOTSTRAP
 *----------------------------------------
 */
require_once SERVER_ROOT . 'system/core/Bootstrap.php';