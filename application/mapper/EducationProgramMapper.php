<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\EducationProgramObject;

class EducationProgramMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('education_program');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setUniversity($data['university']);
		$object->setAbbr($data['abbr']);
		$object->setLocation($data['location']);
		$object->setLink($data['link']);
		$object->setType($data['type']);
	}


	protected function _createAction()
	{
		return new EducationProgramObject();
	}


	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				university,
				abbr,
				location,
				link,
				type
			)
			VALUES(
				:uid,
				:university,
				:abbr,
				:location,
				:link,
				:type
			)
			',
			array(
				':uid' => $object->getUid(),
				':university' => $object->getUniversity(),
				':abbr' => $object->getAbbr(),
				':location' => $object->getLocation,
				':link' => $object->getLink(),
				':type' => $object->getType()
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
				university = :university,
				abbr = :abbr,
				location = :location,
				link = :link,
				type = :type
			WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':university' => $object->getUniversity(),
				':abbr' => $object->getAbbr(),
				':location' => $object->getLocation,
				':link' => $object->getLink(),
				':type' => $object->getType()
			)
		);
		
		return $this->pdo->execute();
	}
}