<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class ProjectMetaObject extends DomainObjectAbstract
{
	private $projectUid;
	private $accountUid;
	private $role;

	public function getProjectUid()
	{
		return $this->projectUid;
	}


	public function getAccountUid()
	{
		return $this->accountUid;
	}


	public function getRole()
	{
		return $this->role;
	}


	public function setProjectUid($project)
	{
		$this->projectUid = $project;
	}


	public function setAccountUid($account)
	{
		$this->accountUid = $account;
	}


	public function setRole($role)
	{
		$this->role = $this->role;
	}

}