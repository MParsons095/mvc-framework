<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class AccountMetaModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function findByAccountUid($uid)
	{
		$this->verifyMapper();
		$uid = $this->hasValidUid($uid);

		if(!$uid)
		{
			return false;
		}

		$this->mapper->select(array(
			'where' => array(':accountUid' => $uid),
			'limit' => 1
		));

		$result = $this->mapper->pdo->single();

		if(is_string($result))
		{
			$this->addError($result);
			return null;
		}

		$object = $this->mapper->create();
		$this->mapper->populate($object,$result);

		$this->addSuccess($object);
		return $object;
	}

	public function save($data)
	{
		$this->verifyMapper();

		if( !isset($data['accountUid']) ||
			!isset($data['yearJoined']) ||
			!isset($data['bio']) ||
			!isset($data['picture'])
			)
		{
			$this->addError('Internal Error: Missing Data');
			return false;
		}


		$object = $this->mapper->create();

		$object->setAccountUid($this->validator->sanitize($data['accountUid']));
		$object->setYearJoined($this->validator->sanitize($data['yearJoined']));
		$object->setBio($this->validator->sanitize($data['bio']));
		$object->setPicture($this->validator->sanitize($data['picture']));

		if(!$this->validator->validate($object->getAccountUid(),'uuid'))
		{
			$this->addError('Invalid Account ID Provided');
		}

		if(!$this->validator->validate($object->getYearJoined(),'int'))
		{
			$this->addError('Invalid value for \'Year Joined\' field');
		}

		if(!$this->validator->validate($object->getBio(),'text'))
		{
			$this->addError('Only alphbetic, numeric, and puncuation characters are allowed in the \'bio\' field');
		}

		if(!$this->validator->validate($object->getPicture(),'alphaNumeric',false))
		{
			$this->addError('Invalid profile picture provided. Please refresh and re-upload the picture.');
		}

		if($object->getPicture() == null || $object->getPicture() == 'null')
		{
			$object->setPicture('placeholder');
		}
		else
		{
			$picturePath = SERVER_ROOT . 'public/temp/image/' . $object->getPicture() . '.jpg';

			if(!is_file($picturePath) || !rename($picturePath,SERVER_ROOT . 'public/system/image/' . $object->getPicture() . '.jpg'))
			{
				$this->addError('Failed to process profile picture. Please refresh and try again.');
				$this->addError('Path: ' . $picturePath);
			}
		}

		if($this->hasErrors())
		{
			return false;
		}


		$action = $this->mapper->save($object);

		if(is_string($action))
		{
			$this->addError($action);
			return false;
		}

		$this->addSuccess(true);
	}
}