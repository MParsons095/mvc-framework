<?php namespace System\Core;

class Model
{
	protected $config;
	public $pdo;


	public function __construct()
	{
		$this->config = load_class('Config','system/core');
		$this->validator = load_class('Validator','system/helper');
		$this->pdo = load_class('PDOAdapter', 'system/core');
	}
}