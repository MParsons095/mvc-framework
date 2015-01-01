<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\AwardMetaObject;

class AwardMetaMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('award_meta');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setCompetition($data['competition']);
	}


	protected function _createAction()
	{
		return new AwardMetaObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				competition
			)
			VALUES(
				:uid,
				:competition
			)
			',
			array(
				'uid' => $object->getUid(),
				':competition' => $object->getCompetition()
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
					competition = :competition
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':accountUid' => $object->getAccountUid(),
				':competition' => $object->getCompetition()
			)
		);

		return $this->pdo->execute();
	}
}