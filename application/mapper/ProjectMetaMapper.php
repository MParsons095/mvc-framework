<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\ProjectMetaObject;

class ProjectMetaMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('project_meta');
	}

	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setProjectUid($data['projectUid']);
		$object->setAccountUid($data['accountUid']);
		$object->setRole($data['role']);
	}


	protected function _createAction()
	{
		return new ProjectMetaObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				projectUid,
				accountUid,
				role
			)
			VALUES(
				:uid,
				:projectUid,
				:accountUid,
				:role
			)
			',
			array(
				':uid' => $object->getUid(),
				':projectUid' => $object->getProjectUid(),
				':accountUid' => $object->getAccountUid(),
				':role' => $object->getRole()
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
					projectUid = :projectUid,
					accountUid = :accountUid,
					role = :role
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':projectUid' => $object->getProjectUid(),
				':accountUid' => $object->getAccountUid(),
				':role' => $object->getRole()
			)
		);

		return $this->pdo->execute();
	}
}