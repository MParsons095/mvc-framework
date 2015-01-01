<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class RegisterModel extends ServiceAbstract
{
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $confirmPassword;
	private $slug;

	public function __construct()
	{
		parent::__construct();
	}


	public function run(array $data)
	{
		$this->verifyMapper();
		$this->verifyObject();

		if(
			!isset($data['firstName']) ||
			!isset($data['lastName']) ||
			!isset($data['email']) ||
			!isset($data['password'])||
			!isset($data['confirmPassword'])
		)
		{
			$this->addError('Some Information was not submitted.');
			return;
		}

		$this->firstName = $this->validator->sanitize($data['firstName'],'alpha');
		$this->lastName = $this->validator->sanitize($data['lastName'],'alpha');
		$this->email = $this->validator->sanitize($data['email'],'email');
		$this->password = $this->validator->sanitize($data['password'],'alphaNumeric');
		$this->confirmPassword = $this->validator->sanitize($data['confirmPassword'],'alphaNumeric');

		if(!$this->validateData())
		{
			return;
		}

		$this->hashPassword();
		$this->generateSlug();
		
		$this->mapper->populate($this->object,array(
			'uid' => null,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'email' => $this->email,
			'password' => $this->password,
			'salt' => $this->salt,
			'slug' => $this->slug,
			'accountType' => 'user'
		));

		$this->insertIntoDatabase();
		$this->addSuccess('You have successfully registered!');
	}


	private function validateData()
	{
		$valid = true;

		if(!$this->validateFirstName() || !$this->validateLastName())
		{
			$this->addError('Invalid First or Last Name: Only alphabetic characters are allowed.');
			$valid = false;
		}

		if(!$this->validateEmail())
		{
			$this->addError('Invalid Email: Your email should be in xxx@yyy.zzz');
			$valid = false;
		}

		if(!$this->validatePassword())
		{
			$this->addError('Invalid Password: Only alpha-numeric characters are allowed.');
			$valid = false;
		}

		if(!$this->comparePasswords())
		{
			$this->addError('Both password must match.');
			$valid = false;
		}

		return $valid;
	}


	private function validateFirstName()
	{
		if($this->validator->validate($this->firstName,'alpha'))
		{
			return true;
		}

		return false;
	}


	private function validateLastName()
	{
		if($this->validator->validate($this->lastName,'alpha'))
		{
			return true;
		}

		return false;
	}


	private function validateEmail()
	{
		if($this->validator->validate($this->email,'email'))
		{
			return true;
		}

		return false;
	}


	private function validatePassword()
	{
		if($this->validator->validate($this->password,'alphaNumeric') ||
			$this->validator->validate($this->confirmPassword,'alphaNumeric')
		)
		{
			return true;
		}

		return false;
	}


	private function comparePasswords()
	{
		if($this->password === $this->confirmPassword)
		{
			return true;
		}

		return false;
	}


	private function hashPassword()
	{
		$this->salt = $this->hash->salt();
		$this->password = $this->hash->generateSha256($this->password,$this->salt);
	}


	private function generateSlug()
	{
		$this->slug = strtolower($this->firstName . '-' . $this->lastName);
		$this->mapper->pdo->query('SELECT * FROM account WHERE slug = :slug',array(':slug' => $this->slug));
		$this->mapper->pdo->results();

		if($this->mapper->pdo->count() > 0)
		{
			$this->slug .= '-' . ($this->mapper->pdo->count() + 1);
		}
	}


	private function insertIntoDatabase()
	{
		$return = $this->mapper->save($this->object);

		if(is_string($return))
		{
			$this->addError($return);
		}
	}
}