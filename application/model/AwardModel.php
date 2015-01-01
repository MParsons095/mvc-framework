<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class AwardModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function selectAll()
	{
		$this->verifyMapper();

		$this->mapper->pdo->query('
			SELECT
				award.placing,
				award.yearOf,
				award.level,
				(SELECT competition FROM award_meta WHERE award_meta.uid = award.awardMetaUid) as competition,
				(SELECT firstName FROM account WHERE account.uid = award.accountUid) as firstName,
				(SELECT lastName FROM account WHERE account.uid = award.accountUid) as lastName,
				(SELECT picture FROM account_meta WHERE account_meta.accountUid = award.accountUid) as picture
			FROM award
			ORDER BY yearOf DESC, competition DESC, placing ASC
		',array());

		$result = $this->mapper->pdo->results();

		if(is_string($result))
		{
			$this->addError($result);
			return $result;
		}

		$this->addSuccess($result);
		return $result;
	}


	public function selectAllByAccountUid($data)
	{
		$this->verifyMapper();
		$uid = $this->hasValidUid($data['uid']);

		if(!$uid)
		{
			return false;
		}

		$this->mapper->pdo->query('
				SELECT
					uid,
					accountUid,
					awardMetaUid,
					level,
					placing,
					yearOf,
					(SELECT competition FROM award_meta WHERE award.awardMetaUid = uid)
						AS competition
				FROM 
					award
				WHERE accountUid = :accountUid
			',
			array(':accountUid' => $uid)
		);

		$result = $this->mapper->pdo->results();

		if(is_string($result))
		{
			$this->addError($result);
			return null;
		}

		$this->addSuccess($result);
		return $result;
	}



	public function save($data)
	{
		$this->verifyMapper();

		if( !isset($data['accountUid']) ||
			!isset($data['awardMetaUid']) ||
			!isset($data['placing']) ||
			!isset($data['yearOf']) ||
			!isset($data['level'])
			)
		{
			$this->addError('Internal Error: Missing Data');
			return false;
		}

		$object = $this->mapper->create();

		$object->setAccountUid($this->validator->sanitize($data['accountUid']));
		$object->setAwardMetaUid($this->validator->sanitize($data['awardMetaUid']));
		$object->setPlacing($this->validator->sanitize($data['placing']));
		$object->setYearOf($this->validator->sanitize($data['yearOf']));
		$object->setLevel($this->validator->sanitize($data['level']));

		if( !$this->validator->validate($object->getAccountUid(),'uuid') ||
			!$this->validator->validate($object->getAwardMetaUid(),'uuid')
			)
		{
			$this->addError('Internal Error: Invalid unique ID. Please refresh and try again');
		}

		if(!$this->validator->validate($object->getPlacing(),'int') || !$this->validator->range(1,10,$object->getPlacing()))
		{
			$this->addError('Placing must be a numeric value between 1 and 10');
		}

		if( !$this->validator->validate($object->getYearOf(),'int') ||
			!$this->validator->range(date("Y") - 20, date("Y"),$object->getYearOf()))
		{
			$this->addError('Year must be in the range' . date("Y") - 20 . ' and ' . date("Y"));
		}

		if(!$this->validator->validate($object->getLevel(),'alpha'))
		{
			$this->addError('Invalid competition level given');
		}

		if($this->hasErrors())
		{
			return false;
		}

		$save = $this->mapper->save($object);

		if(is_string($save))
		{
			$this->addError('Internal Error: Failed to save award');
			return false;
		}

		$this->addSuccess(true);
	}


	public function delete($data)
	{
		$this->verifyMapper();
		$uid = $this->hasValidUid($data['uid']);

		if(!$uid)
		{
			return false;
		}

		$object = $this->mapper->create();
		$object->setUid($uid);
		$result = $this->mapper->delete($object);

		if(is_string($result))
		{
			return null;
		}

		return true;
	}
}