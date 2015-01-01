<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class LoginModel extends ServiceAbstract
{
	private $email;
	private $password;
	
	public function __construct()
	{
		parent::__construct();
	}


	public function run(array $data)
	{
		$this->verifyMapper();

		if(isset($data['email']) && isset($data['password']))
		{
			$this->email = $this->validator->sanitize($data['email'],'email');
			$this->password = $this->validator->sanitize($data['password'],'special');
			return $this->process();
		}
		else
		{
			$this->addError('Both an email and password must be provided!');
			return false;
		}
	}



	private function process()
	{
		if(!$this->validateLoginDetails())
		{
			return false;
		}

		if(!$this->searchDatabase() || !$this->comparePasswords())
		{
			$this->addError('Sorry. We couldn\'t find an account with those details');
			return false;
		}

		$this->setSession();
		$this->addSuccess('You have logged in successfully!');
	}



	private function validateLoginDetails()
	{
		$valid = true;


		if(!$this->validateEmail())
		{
			$this->addError('Invalid Email: Your email should be in xxx@yyy.zzz format.');
			$valid = false;
		}


		if(!$this->validatePassword())
		{
			$this->addError('Invalid Password: Only alpha-numeric characters are allowed.');
			$valid = false;
		}

		return $valid;
	}



	private function validateEmail()
	{
		return $this->validator->validate($this->email,'email');
	}



	private function validatePassword()
	{
		return $this->validator->validate($this->password,'alphaNumeric');
	}



	private function searchDatabase()
	{
		$query = $this->mapper->findByEmail($this->email);

		if(!$query || !is_array($query))
		{
			return false;
		}

		$this->mapper->populate($this->object,$query);
		return true;
	}


	private function comparePasswords()
	{
		if($this->hash->generateSha256($this->password, $this->object->getSalt()) != $this->object->getPassword())
		{
			return false;
		}

		return true;
	}


	private function setSession()
	{
		$this->session->start();
		$this->session->set('uid', $this->object->getUid());
		$this->session->set('id', $this->hash->salt());
		$this->session->set('name', $this->object->getFirstName()  . ' ' . $this->object->getLastName());
		$this->session->set('accountType',$this->object->getAccountType());
		$this->session->set('lastActivity', time());	
	}
}