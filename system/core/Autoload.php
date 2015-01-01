<?php
spl_autoload_register(function($partials)
{
	//remove the namespace from the class identifier
	$partials = explode('\\',$partials);
	$class = array_pop($partials);
	$namespace = implode('/',$partials);

	switch (end($partials)) {
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

	$file = $class . $extension . '.php';
	//$path = strtolower($namespace) . '/' . $file;
    $path = explode('/',$namespace);
	$pathStr = '';
	foreach($path as $item)
	{
		$pathStr .= lcfirst($item) . '/';
	}

	$path = $pathStr . $file;

	if(is_file($path))
	{
		require_once $path;
		return;
	}


	//if a valid path is not found, log as an internal error
	try
	{
    	print '<h1>' . $path . ' == test </h1>';
		debug_trace(true);
		throw new Exception('Autoload Failure: Class ' . $class . ' not found in application or system directories.');
	}
	catch(Exception $e)
	{
		log_internal_error($e, array('Namespace' => implode('\\',$partials),'Attempted Path' => $path));
		load_internal_error('Required File Missing.');
	}
});