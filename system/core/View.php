<?php namespace System\Core;

use \Exception;

class View
{
	//the title of the web page
	private $title;

	//partials to be loaded
	private $component;

	//variables to be passed into the view
	private $var;

	//javascript files to be loaded
	private $js;

	//extra stylesheets to be loaded
	private $stylesheet;

	//Session Class instance
	private $Session;



	public function __construct()
	{
		$this->var = array();
		$this->Session = load_class('Session','system/library');
	}



	/**
	 *	Set the page title.
	 *	@param String $string - the title
	 */
	public function setTitle($string)
	{
		$this->title = $string;
	}



	/**
	 *	Get the page title.
	 *	@return String
	 */
	public function getTitle()
	{
		return $this->title;
	}



	/**
	 *	Store view partials.
	 *	The output of the render method is dependent 
	 *	@param String $file - the file of the partial view to be included
	 */
	public function addComponent($file)
	{
		$this->component[] = $file;
	}



	/**
	 *	Include each component to display the complete view.
	 */
	public function loadComponents()
	{
		//load vars into view
		extract($this->var);

		//load custom javascript files
		$js = $this->loadJS();


		//load pieces of view
		try
		{
			foreach($this->component AS $file)
			{
				$path = APP_PATH . 'view/' . $file . 'View.php';

				if(is_file($path))
				{
					include $path;
				}
				else
				{
					throw new Exception('View Component "' . $file . '" at path: ' . $path);
				}
			}
		}
		catch(Exception $e)
		{
			log_internal_error($e);
			load_internal_error('Failed to load page. Please contact an administrator.');
		}
	}



	/**
	 *	Pass a variable into the view.
	 *	@param String $key - the name of the variable
	 *	@param Mixed $value - the value of the variable
	 */
	public function addVar($key,$value)
	{
		$this->var[$key] = $value;
	}



	/**
	 *	Load a page-specific javascript file into the view.
	 *	@param String $path - the path to the javascript file
	 */
	public function addJS($path)
	{
		$this->js[] = $path;
	}



	/**
	 *	Return the javascript files in HTML format.
	 */
	public function loadJs()
	{
		if(is_array($this->js))
		{
			$js = '';

			foreach($this->js AS $file)
			{
				$path = PUBLIC_PATH . 'javascript/' . $file . '.js';

				if(is_file($path))
				{
					$js .= '<script type="text/javascript" src="' . DOMAIN_ROOT . 'public/javascript/' .  $file . '.js"></script>';
				}
				else
				{
					log_runtime_error('View::loadJs() -> File: ' . $path . ' not found.','system/core/View.php','149');
				}
			}
		
		return $js;
		}
	}



	/**
	 *	Load a page-specific stylesheet into the view.
	 *	@param String $path - the path to the css file
	 */
	public function addStylesheet($path)
	{
		$this->stylesheet[] = $path;
	}



	/**
	 *	Return the css files in HTML format.
	 */
	public function loadStylesheets()
	{
		if(is_array($this->stylesheet))
		{
			$css = '';
			foreach($this->stylesheet AS $file)
			{
				$css .= '<link rel="stylesheet" type="text/css" href="' . BASE_PATH . $file . '" />';

			}

			return $css;
		}
	}



	/**
	 *
	 */
	public function render()
	{
		//load view contents in the order in which they were added
		$this->loadComponents();
	}
}