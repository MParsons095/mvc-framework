<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class CourseMetaObject extends DomainObjectAbstract
{
	private $courseId;
	private $type;
	private $value;
	private $isRequired;
	private $childOf;

	public function getCourseId()
	{
		return $this->courseId;
	}


	public function getType()
	{
		return $this->type;
	}


	public function getValue()
	{
		return $this->value;
	}


	public function getIsRequired()
	{
		return $this->isRequired;
	}


	public function getChildOf()
	{
		return $this->childOf;
	}


	public function setCourseId($uid)
	{
		$this->courseId = $uid;
	}


	public function setType($type)
	{
		$this->type = $type;
	}


	public function setValue($value)
	{
		$this->value = $value;
	}


	public function setIsRequired($bool)
	{
		$this->isRequired = $bool;
	}


	public function setChildOf($bool)
	{
		$this->childOf = $bool;
	}
}