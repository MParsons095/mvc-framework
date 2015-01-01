<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class EducationProgramObject extends DomainObjectAbstract
{
	private $university;
	private $abbr;
	private $location;
	private $link;
	private $type;


	public function getUniversity()
	{
		return $this->university;
	}


	public function getAbbr()
	{
		return $this->abbr;
	}


	public function getLocation()
	{
		return $this->location;
	}


	public function getLink()
	{
		return $this->link;
	}


	public function getType()
	{
		return $this->type;
	}


	public function setUniversity($university)
	{
		$this->university = $university;
	}


	public function setAbbr($abbr)
	{
		$this->abbr = $abbr;
	}


	public function setLocation($loc)
	{
		$this->location = $loc;
	}


	public function setLink($link)
	{
		$this->link = $link;
	}


	public function setType($type)
	{
		$this->type = $type;
	}
}