<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\CourseMetaObject;

class CourseMetaMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('course_meta');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setCourseId($data['courseId']);
		$object->setType($data['type']);
		$object->setvalue($data['value']);
		$object->setIsRequired($data['isRequired']);
		$object->setChildOf($data['childOf']);
	}


	protected function _createAction()
	{
		return new CourseMetaObject();
	}


	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				courseId,
				type,
				value,
				isRequired,
				childOf
			)
			VALUES(
				:uid,
				:courseId,
				:type,
				:value,
				:isRequired,
				:childOf
			)
			',
			array(
				':uid' => $object->getUid(),
				':courseId' => $object->getCourseId(),
				':type' => $object->getType(),
				':value' => $object->getValue(),
				':isRequired' => $object->getIsRequired(),
				':childOf' => $object->getChildOf()
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
				courseId = :courseId,
				type = :type,
				value = :value,
				isRequired = :isRequired,
				childOf = :childOf
			WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':courseId' => $object->getCourseId(),
				':type' => $object->getType(),
				':value' => $object->getValue(),
				':isRequired' => $object->getIsRequired(),
				':childOf' => $object->getChildOf()
			)
		);
		
		return $this->pdo->execute();
	}
}