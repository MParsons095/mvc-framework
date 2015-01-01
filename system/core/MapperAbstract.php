<?php namespace System\Core;

use \System\Core\DomainObjectAbstract,
	\System\Core\Model;

/**
 *	@author Brenton Alker - Deprecated Behavior Blog
 *	Source - http://blog.tekerson.com/2008/12/17/data-mapper-pattern-in-php/
 */
abstract class MapperAbstract extends Model
{
	protected $table;

	public function __construct()
	{
		parent::__construct();
	}


	public function setTable($table)
	{
		$this->table = $table;
	}


	public function selectAll()
	{
		$this->pdo->query('SELECT * FROM ' . $this->table);
		return $this->pdo->results();
	}


	public function select(Array $queryParams)
	{
		$where = ' WHERE ';
		$orderBy = ' ORDER BY ';
		$limit = ' LIMIT ';
		$groupBy = ' GROUP BY ';

		if(isset($queryParams['where']))
		{
			$x = 0;

			foreach($queryParams['where'] AS $placeholder => $bindValue)
			{
				if($x == count($queryParams['where']) - 1)
				{
					$where .= substr($placeholder, 1) . '= ' . $placeholder;
				}
				else
				{
					$where .= substr($placeholder, 1) . '= ' . $placeholder . ' AND ';
				}

				$x++;
			}
		}
		else
		{
			$where = '';
			$queryParams['where'] = array();
		}

		if(isset($queryParams['orderBy']))
		{
			$x = 0;

			foreach($queryParams['orderBy'] as $col => $order)
			{
				if($x == count($queryParams['orderBy']) - 1)
				{
					$orderBy .= $col . ' ' . $order;
				}
				else
				{
					$orderBy .= $col . ' ' . $order . ', ';
				}

				$x++;
			}
		}
		else
		{
			$orderBy = '';
		}

		if(isset($queryParams['limit']))
		{
			$limit .= ' ' . $queryParams['limit'];
		}
		else
		{
			$limit = '';
		}

		if(isset($queryParams['groupBy']))
		{
			$x = 0;

			foreach($queryParams['groupBy'] as $col)
			{
				if($x == count($queryParams['groupBy']) - 1)
				{
					$groupBy .= $col;
				}
				else
				{
					$groupBy .= $col . ', ';
				}

				$x++;
			}
		}
		else
		{
			$groupBy = '';
		}


		$this->pdo->query('SELECT * FROM ' . $this->table . $groupBy . $where . $orderBy . $limit,$queryParams['where']);
		
		return $this->pdo->results();
	}



	public function count($where = array())
	{
		$whereStmt = '';

		if(is_array($where) && count($where) > 0)
		{
			$whereStmt .= ' WHERE ';
			foreach($where as $column => $value)
			{
				$whereStmt .= $column . ' = :' . $column;
			}
		}

		$this->pdo->query('SELECT COUNT(*) as count FROM ' . $this->table . ' ' . $whereStmt,$where); 
		return $this->pdo->single();
	}



	public function selectWhere(Array $array)
	{
		$where = '';
		$x = 0;

		foreach($array AS $placeholder => $bindValue)
		{
			if($x == count($array) - 1)
			{
				$where .= substr($placeholder, 1) . '= ' . $placeholder;
			}
			else
			{
				$where .= substr($placeholder, 1) . '= ' . $placeholder . ' AND ';
			}

			$x++;
		}

		$this->pdo->query('SELECT * FROM ' . $this->table . ' WHERE ' . $where,$array);

		return $this->pdo->results();
	}


	public function findByUid($uid)
	{
		$this->pdo->query('SELECT * FROM ' . $this->table . ' WHERE uid = :uid',array(':uid' => $uid));

		$result = $this->pdo->single();

		if(is_array($result))
		{
			$object = $this->create();
			$this->populate($object,$result);

			return $object;
		}

		return null;
	}


	public function findBySlug($slug)
	{
		$this->pdo->query('SELECT * FROM ' . $this->table . ' WHERE slug = :slug',array(':slug' => $slug));
		$result = $this->pdo->single();

		if(is_array($result))
		{
			$object = $this->create();
			$this->populate($object,$result);
			
			return $object;
		}

		return null;
	}


	/**
	 *	Create a new instance of the DomainObject.
	 *
	 *	@param array $data
	 *	@return DomainObjectAbstract
	 */
	public function create(array $data = null)
	{
		//create instance
		$object = $this->_createAction();

		//populate
		if($data)
		{
			$object = $this->populate($object, $data);
		}

		return $object;
	}


	/**
	 *	Store the DomainObject to the database.
	 *
	 *	@param DomainObjectAbstract $object
	 */
	public function save(DomainObjectAbstract $object)
	{
		if(is_null($object->getUid()))
		{
			$object->setUid($this->pdo->uuid());
			return $this->_insertAction($object);
		}
		else
		{
			return $this->_updateAction($object);
		}
	}


	/**
	 *	Delete DomainObject from the database.
	 *	@param Domain ObjectAbstract $object
	 */
	public function delete(DomainObjectAbstract $object)
	{
		return $this->_deleteAction($object);
	}


	/**
	 *	Populate object with values from the data
	 *	array. This will be implemented by a concrete mapper.
	 *
	 *	@param DomainObjectAbstract $object
	 *	@param array $data
	 */
	abstract public function populate(DomainObjectAbstract $object, array $data);


	/**
	 *	create a new instance of the domain object
	 */
	abstract protected function _createAction();


	/**
	 *	Insert the DomainObject into database.
	 *	@param DomainObjectAbstract $object
	 */
	abstract protected function _insertAction(DomainObjectAbstract $object);


	/**
	 *	Update the DomainObject in the database.
	 *	@param DomainObjectAbstract $object
	 */
	abstract protected function _updateAction(DomainObjectAbstract $object);


	/**
	 *	Delete the DomainObject from the Database
	 *	@param DomainObjectAbstract $object
	 */
	abstract protected function _deleteAction(DomainObjectAbstract $object);
}