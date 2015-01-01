<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class AccountMetaObject extends DomainObjectAbstract
{
	private $accountUid;
	private $bio;
	private $yearJoined;
	private $picture;

	public function getAccountUid()
	{
		return $this->accountUid;
	}

	public function getBio()
	{
		return $this->bio;
	}

	public function getYearJoined()
	{
		return $this->yearJoined;
	}

	public function getPicture()
	{
		return $this->picture;
	}

	public function setAccountUid($uid)
	{
		$this->accountUid = $uid;
	}

	public function setBio($bio)
	{
		$this->bio = $bio;
	}

	public function setYearJoined($year)
	{
		$this->yearJoined = $year;
	}

	public function setPicture($picture)
	{
		$this->picture = $picture;
	}
}