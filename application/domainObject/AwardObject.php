<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class AwardObject extends DomainObjectAbstract
{
	private $accountUid;
	private $awardMetaUid;
	private $level;
	private $placing;
	private $yearOf;

	public function getAccountUid()
	{
		return $this->accountUid;
	}

	public function getAwardMetaUid()
	{
		return $this->awardMetaUid;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function getPlacing()
	{
		return $this->placing;
	}

	public function getYearOf()
	{
		return $this->yearOf;
	}

	public function setAccountUid($uid)
	{
		$this->accountUid = $uid;
	}

	public function setAwardMetaUid($uid)
	{
		$this->awardMetaUid = $uid;
	}

	public function setPlacing($place)
	{
		$this->placing = $place;
	}

	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function setYearOf($year)
	{
		$this->yearOf = $year;
	}
}