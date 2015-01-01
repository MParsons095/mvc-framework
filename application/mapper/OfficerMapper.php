<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\OfficerObject;

class OfficerMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('tsa_officer');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setAccountUid($data['accountUid']);
		$object->setPosition($data['position']);
		$object->setRole($data['role']);
		$object->setListPosition($data['listPosition']);
	}


	protected function _createAction()
	{
		return new OfficerObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				accountUid,
				position,
				role,
				listPosition
			)
			VALUES(
				:uid,
				:accountUid,
				:position,
				:role,
				:listPosition
			)
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':position' => $object->getPosition(),
				':role' => $object->getRole(),
				':listPosition' => $object->getListPosition()
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
					position = :position,
					role = :role,
					listPosition = :listPosition
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':position' => $object->getPosition(),
				':role' => $object->getRole(),
				':listPosition' => $object->getListPosition()
			)
		);

		return $this->pdo->execute();
	}
}