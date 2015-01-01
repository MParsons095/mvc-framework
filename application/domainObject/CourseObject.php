<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class CourseObject extends DomainObjectAbstract
{
	private $title;
	private $slug;
	private $caption;
	private $description;
	private $credit;


	public function getTitle()
	{
		return $this->title;
	}


	public function getSlug()
	{
		return $this->slug;
	}

	public function getCaption()
	{
		return $this->caption;
	}

	public function getDescription()
	{
		return $this->description;
	}


	public function getCredit()
	{
		return $this->credit;
	}


	public function setTitle($String)
	{
		$this->title = $String;
	}


	public function setSlug($string)
	{
		$this->slug = $string;
	}

	public function setCaption($String)
	{
		$this->caption = $String;
	}

	public function setDescription($String)
	{
		$this->description = $String;
	}
	

	public function setCredit($String)
	{
		$this->credit = $String;
	}
}