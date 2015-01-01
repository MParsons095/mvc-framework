<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class AccountObject extends DomainObjectAbstract
{
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $salt;
	private $accountType;
	private $slug;


	public function getFirstName()
	{
		return $this->firstName;
	}

	public function getLastName()
	{
		return $this->lastName;
	}


	public function getEmail()
	{
		return $this->email;
	}


	public function getPassword()
	{
		return $this->password;
	}


	public function getSalt()
	{
		return $this->salt;
	}


	public function getSlug()
	{
		return $this->slug;
	}


	public function getAccountType()
	{
		return $this->accountType;
	}


	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}


	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}


	public function setEmail($email)
	{
		$this->email = $email;
	}


	public function setPassword($password)
	{
		$this->password = $password;
	}


	public function setSalt($salt)
	{
		$this->salt = $salt;
	}


	public function setAccountType($accountType)
	{
		$this->accountType = $accountType;
	}


	public function setSlug($slug)
	{
		$this->slug = $slug;
	}
}