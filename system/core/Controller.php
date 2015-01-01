<?php namespace System\core;

use \System\Library\DataWriter;

abstract class Controller extends DataWriter
{
	public function __construct()
	{
		$this->load = load_class('Loader','system/core');
		$this->load->setInstance($this);
		$this->request = load_class('Request','system/library');
		$this->session = load_class('Session','system/library');
		$this->view = load_class('View','system/core');
	}


	/**
	 *	The defult method to be called when
	 *	one is not provided
	 *
	 *	@return void
	 */
	abstract public function index();
}