<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\AccountMetaObject;

class AccountMetaMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('account_meta');
	}

	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setAccountUid($data['accountUid']);
		$object->setBio($data['bio']);
		$object->setYearJoined($data['yearJoined']);
		$object->setPicture($data['picture']);
	}


	protected function _createAction()
	{
		return new AccountMetaObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				accountUid,
				bio,
				yearJoined,
				picture
			)
			VALUES(
				:uid,
				:accountUid,
				:bio,
				:yearJoined,
				:picture
			)
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':bio' => $object->getBio(),
				':yearJoined' => $object->getYearJoined(),
				':picture' => $object->getPicture()
			)
		);

		return $this->pdo->execute();
	}


	protected function _deleteAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			DELETE FROM `' . $this->table . '`
			WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid()
			)
		);

		return $this->pdo->execute();
	}


	protected function _updateAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
				UPDATE `' . $this->table . '`
				SET
					accountUid = :accountUid,
					bio = :bio,
					yearJoined = :yearJoined,
					picture = :picture
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':bio' => $object->getBio(),
				':yearJoined' => $object->getYearJoined(),
				':picture' => $object->getPicture()
			)
		);

		return $this->pdo->execute();
	}
}