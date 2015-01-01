<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class EducationProgramModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function selectAll()
	{
		$this->addSuccess($this->mapper->selectAll());
		return $this->mapper->selectAll();
	}


	public function search($data)
	{
		$data = $this->verifyData($data,array(
			'queryString'
		));

		if(!$data)
		{
			return false;
		}

		$queryString = $data['queryString'];

		$this->validator->validateGroup(
			array(
				'queryString' => array(
					'value' => $queryString,
					'param' => 'alphaText',
					'validateBy' => 'type',
					'error' => 'Only alphabetic characters are allowed'
				)
			),
			$this
		);

		if(count($this->errorMessages) > 0)
		{
			return;
		}
/*
		$this->mapper->pdo->query('
			SELECT *
			FROM education_program
			WHERE
				university LIKE "%:queryString%"
			OR
				abbr LIKE "%:queryString%"
			OR
				location LIKE "%:queryString%"
			ORDER BY university,abbr,location
			',
			array(':queryString' => $queryString)
		);
		*/
		$this->mapper->pdo->query('
			SELECT *
			FROM education_program
			WHERE
				university LIKE :queryString
			OR
				abbr LIKE :queryString
			OR
				location LIKE :queryString
			ORDER BY university,abbr,location
			',
			array(':queryString' => '%' . $queryString . '%')
		);

		$query = $this->mapper->pdo->results();

		if(!is_array($query))
		{
			$this->addError(null);
			return false; 
		}

		$this->addSuccess($query);
		return $query;
	}
}