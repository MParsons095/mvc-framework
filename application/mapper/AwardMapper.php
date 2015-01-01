<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\AwardObject;

class AwardMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('award');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setAccountUid($data['accountUid']);
		$object->setAwardMetaUid($data['awardMetaUid']);
		$object->setLevel($data['level']);
		$object->setPlacing($data['placing']);
		$object->setYearOf($data['yearOf']);
	}


	protected function _createAction()
	{
		return new AwardObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				accountUid,
				awardMetaUid,
				level,
				placing,
				yearOf
			)
			VALUES(
				:uid,
				:accountUid,
				:awardMetaUid,
				:level,
				:placing,
				:yearOf
			)
			',
			array(
				'uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':awardMetaUid' => $object->getAwardMetaUid(),
				':level' => $object->getLevel(),
				':placing' => $object->getPlacing(),
				':yearOf' => $object->getYearOf()
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
					awardMetaUid = :awardMetaUid,
					level = :level,
					placing = :placing,
					yearOf = :yearOf
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':awardMetaUid' => $object->getAwardMetaUid(),
				':level' => $object->getLevel(),
				':placing' => $object->getPlacing(),
				':yearOf' => $object->getYearOf()
			)
		);

		return $this->pdo->execute();
	}
}