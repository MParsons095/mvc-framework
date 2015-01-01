<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class AwardMetaObject extends DomainObjectAbstract
{
	private $competition;

	public function getCompetition()
	{
		return $this->value();
	}

	public function setCompetition($competition)
	{
		$this->competition = $competition;
	}
}