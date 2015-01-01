<?php namespace System\Core;

class Router
{
	private $uri;
	private $uriString;
	private $config;
	private $defaultController;
	private $controller;
	private $defaultMethod;
	private $method;
	private $params;


	public function __construct()
	{
		$this->config = load_class('Config','system/core');
		$this->uri = load_class('URI','system/core');
		$this->uriString = $this->uri->getSegments();
		$this->setDefaultController();
		$this->setDefaultMethod();
	}


	public function getRoute()
	{
		$this->controller = (isset($this->uriString[0]) ? $this->uriString[0] : $this->defaultController);
		$this->method = (isset($this->uriString[1]) ? $this->uriString[1] : $this->defaultMethod);
		$this->params = (count($this->uriString) > 2) ? $this->parseParams() : array();
	}


	private function setDefaultController()
	{
		$this->defaultController = $this->config->get('route/default_controller');
	}


	private function setDefaultMethod()
	{
		$this->defaultMethod = $this->config->get('route/default_method');
	}


	private function parseParams()
	{
		$tempString = $this->uriString;
		unset($tempString[0],$tempString[1]);

		return array_values($tempString);
	}


	public function getController()
	{
		return ucfirst($this->controller);
	}


	public function getMethod()
	{
		return $this->method;
	}


	public function getParams()
	{
		return $this->params;
	}
}