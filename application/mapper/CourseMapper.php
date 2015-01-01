<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\CourseObject;

class CourseMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('course');
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setTitle($data['title']);
		$object->setSlug($data['slug']);
		$object->setCaption($data['caption']);
		$object->setDescription($data['description']);
		$object->setCredit($data['credit']);
	}


	protected function _createAction()
	{
		return new CourseObject();
	}


	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `course`
			(
				uid,
				title,
				slug,
				caption,
				description,
				credit
			)
			VALUES(
				:uid,
				:title,
				:slug,
				:caption,
				:description,
				:credit
			)
			',
			array(
				':uid' => $object->getUid(),
				':title' => $object->getTitle(),
				':slug' => $object->getSlug(),
				':caption' => $object->getCaption(),
				':description' => $object->getDescription(),
				':credit' => $object->getCredit()
			)
		);

		return $this->pdo->execute();
	}


	protected function _deleteAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			DELETE FROM `course`
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
			UPDATE `course`
			SET
				title = :title,
				slug = :slug,
				caption = :caption,
				description = :description,
				credit = :credit
			WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':title' => $object->getTitle(),
				':slug' => $object->getSlug(),
				':caption' => $object->getCaption(),
				':description' => $object->getDescription(),
				':credit' => $object->getCredit()
			)
		);
		
		return $this->pdo->execute();
	}
}