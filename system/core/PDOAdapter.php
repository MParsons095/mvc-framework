<?php namespace System\Core;

use \PDO,
	\PDOException,
	\System\Library\PDOAdapterException;

class PDOAdapter extends PDOAdapterException
{
	private $config;
	private $host;
	private $user;
	private $password;
	private $name;
	private $pdo;
	private $query;
	private $printableQuery;
	private $pdoSettings;


	public function __construct()
	{
		$this->config = load_class('Config','system/core');
		$this->host = $this->config->get('database/host');
		$this->user = $this->config->get('database/user');
		$this->password = $this->config->get('database/password');
		$this->name = $this->config->get('database/name');

		try
		{
			$this->pdoSettings = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			$this->pdo = new PDO("mysql:host=$this->host;dbname=$this->name",$this->user,$this->password, $this->pdoSettings);
		}
		catch(PDOException $e)
		{
			log_internal_error($e);
			load_internal_error('Error Processing Request.');
		}
	}


	/**
	 *	Prepare database query
	 *	@param String $query - statement to be queried
	 */
	public function query($query, array $binds = array())
	{
		$this->printableQuery = $query;

		foreach($binds as $b => $v)
		{
			$this->printableQuery = str_replace($b, $v, $this->printableQuery);
		}


		$this->query = $this->pdo->prepare($query);

		foreach($binds AS $placeholder => $value)
		{
			$this->bind($placeholder, $value);
		}
	}


	/**
	 *	Binds parameter to query
	 *	@param String $placeholder
	 */
	public function bind($placeHolder, $value)
	{
		$type = null;

		switch (true) {
			case is_int($value):
				$type = PDO::PARAM_INT;
				break;
			case is_bool($value):
				$type = PDO::PARAM_BOOL;
				break;
			case is_null($value):
				$type = PDO::PARAM_NULL;
				break;
			default:
				$type = PDO::PARAM_STR;
		}

		$this->query->bindValue($placeHolder, $value, $type);
	}


	/**
	 *	Execute the query
	 */
	public function execute()
	{
		try
		{
			$this->query->execute();
		}
		catch(PDOException $e)
		{
			log_internal_error($e);
			return $this->getMessage($e);
		}
	}


	/**
	 *	Return a multi-dimensional array from the results of a query.
	 *	This is used if multiple rows are, or could be, returned.
	 */
	public function results()
	{
		$exec = $this->execute();
		$results = $this->query->fetchAll(PDO::FETCH_ASSOC);

		if(!$results || $results == 0)
		{
			return 'No Results Found';
		}

		return $results;
	}


	/**
	 *	Return a single dimensional array from the results of a query.
	 *	This is used if no more than a single row will be returned.
	 */
	public function single()
	{
		$exec = $this->execute();
		$results = $this->query->fetch(PDO::FETCH_ASSOC);

		if(!$results || $results == 0)
		{
			return 'No Results Found';
		}

		return $results;
	}


	/**
	 *	Count the number of rows affected, or rows returned.
	 */
	public function count()
	{
		return $this->query->rowCount();
	}


	/**
	 *	Get the ID of the last item inserted into a database
	 */
	public function lastId()
	{
		return $this->query->lastInsertId();
	}


	/**
	 *	Begin a multi-query transaction.
	 */
	public function start()
	{
		return $this->query->beginTransaction();
	}


	/**
	 *	End a multi-query transaction.
	 */
	public function end()
	{
		return $this->query->commit();
	}


	/**
	 *	Rollback if all queries in a transaction if
	 *	a failure is detected.
	 */
	public function roll()
	{
		return $this->query->rollBack();
	}


	/**
	 *	Dump the query and it's contents for debugging purposes.
	 */
	public function debugQuery()
	{
		return $this->query->debugDumpParams();
	}


	/**
	 *	Generate a universally unique ID
	 */
	public function uuid() {
		$this->query("SELECT UUID() AS uuid");
		$result = $this->single();
		return $result['uuid'];
	}
}