<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\ProjectObject;

class ProjectMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('project');
	}

	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setTitle($data['title']);
		$object->setDescription($data['description']);
		$object->setSlug($data['slug']);
		$object->setPicture($data['picture']);
		$object->setAuthor($data['author']);
	}


	protected function _createAction()
	{
		return new ProjectObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				slug,
				title,
				description,
				picture,
				author
			)
			VALUES(
				:uid,
				:slug,
				:title,
				:description,
				:picture,
				:author
			)
			',
			array(
				':uid' => $object->getUid(),
				':slug' => $object->getSlug(),
				':title' => $object->getTitle(),
				':description' => $object->getDescription(),
				':picture' => $object->getPicture(),
				':author' => $object->getAuthor()
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
					slug = :slug,
					title = :title,
					description = :description,
					picture = :picture,
					author = :author
			',
			array(
				':slug' => $object->getSlug(),
				':title' => $object->getTitle(),
				':description' => $object->getDescription(),
				':picture' => $object->getPicture(),
				':author' => $object->getAuthor()
			)
		);

		return $this->pdo->execute();
	}
}