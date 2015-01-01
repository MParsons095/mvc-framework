<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class ProjectMetaModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function selectProjectAccounts($projectId)
	{
		$accounts = $this->mapper->select(array(
			'where' => array(':projectUid' => $projectId)
		));

		if(is_array($accounts))
		{
			$accountObj = array();

			foreach($accounts as $account)
			{
				$this->mapper->pdo->query('
					SELECT firstName,lastName,slug
					FROM  account
					WHERE uid = :uid
				',array(':uid' => $account['accountUid']));

				$accountObj[] = $this->mapper->pdo->single();
			}

			return $accountObj;
		}
		else
		{
			debug_dump($accounts);
			return false;
		}
	}


	public function selectProjects($data)
	{
		$this->verifyMapper();

		if(!isset($data['accountUid']))
		{
			$this->addError('Internal Error: Missing Data');
			return false;
		}


		$accountUid = $this->validator->sanitize($data['accountUid']);

		if(!$this->validator->validate($accountUid,'uuid'))
		{
			$this->addError('Invalid Account ID');
			return false;
		}

		$this->mapper->pdo->query('
			SELECT *
			FROM project_meta
			WHERE accountUid = :accountUid
		');
	}


	public function save($data)
	{
		$this->verifyMapper();

		if(!$this->verifyData($data,array(
			'uid',
			'accountUid',
			'projectUid',
			'role'
		)))
		{
			return false;
		}

		$this->mapper->populate(
			$this->object,
			$this->validator->sanitizeGroup($data)
		);

		$this->validator->validateGroup(
			array(
				'projectUid' => array(
					'value' => $this->object->getProjectUid(),
					'param' => 'uuid',
					'validateBy' => 'type',
					'error' => 'Invalid Project Unique ID'
				),
				'accountUid' => array(
					'value' => $this->object->getAccountUid(),
					'param' => 'uuid',
					'validateBy' => 'type',
					'error' => 'Invalid Account Unique ID'
				),
				'role' => array(
					'value' => $this->object->getRole(),
					'param' => 'text',
					'validateBy' => 'type',
					'error' => 'Only alphabetic, numeric, and puncuation characters allowed in the \'role\' field'
				)
			),
			$this
		);

		if(count($this->errorMessages) > 0)
		{
			$this->addError($data);
			return;
		}


		$query = $this->mapper->save($this->object);

		if(is_string($query))
		{
			$this->addError($query);
			return; 
		}

		$this->addSuccess('Project Added');
		return true;
	}

	public function delete($data)
	{
		if(!isset($data['uid']))
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}


		$uid = $this->validator->sanitize($data['uid']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Incorrect Data Sent. Please refresh the page and try again.');
			$this->addError($uid);
			return false;
		}

		$this->object->setUid($uid);

		return $this->mapper->delete($this->object);
	}
}