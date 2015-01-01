<?php namespace Application\Mapper;

use \System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract,
	\Application\DomainObject\AccountObject;

class AccountMapper extends MapperAbstract
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('account');
	}


	public function findByEmail($email)
	{
		$this->pdo->query('SELECT * FROM `' . $this->table . '` WHERE email = :email LIMIT 1');
		$this->pdo->bind(':email',$email);
		$this->pdo->execute();

		return $this->pdo->single();
	}


	public function populate(DomainObjectAbstract $object, array $data)
	{
		$object->setUid($data['uid']);
		$object->setFirstName($data['firstName']);
		$object->setLastName($data['lastName']);
		$object->setEmail($data['email']);
		$object->setPassword($data['password']);
		$object->setSalt($data['salt']);
		$object->setAccountType($data['accountType']);
		$object->setSlug($data['slug']);
	}


	protected function _createAction()
	{
		return new AccountObject();
	}

	protected function _insertAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			INSERT INTO `' . $this->table . '`
			(
				uid,
				firstname,
				lastName,
				email,
				password,
				salt,
				accountType,
				slug
			)
			VALUES(
				:uid,
				:firstName,
				:lastName,
				:email,
				:password,
				:salt,
				:accountType,
				:slug
			)
			',
			array(
				':uid' => $object->getUid(),
				':firstName' => $object->getFirstName(),
				':lastName' => $object->getLastName(),
				':email' => $object->getEmail(),
				':password' => $object->getPassword(),
				':salt' => $object->getSalt(),
				':accountType' => $object->getAccountType(),
				':slug' => $object->getSlug()
			)
		);

		return $this->pdo->execute();
	}


	protected function _deleteAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
			DELETE FROM `' . $this->table . '`
			WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid()
			)
		);

		return $this->pdo->execute();
	}


	protected function _updateAction(DomainObjectAbstract $object)
	{
		$this->pdo->query('
				UPDATE `' . $this->table . '`
				SET
					firstName = :firstName,
					lastName = :lastName,
					email = :email,
					password = :password,
					salt = :salt,
					accountType = :accountType,
					slug = :slug
				WHERE uid = :uid
			',
			array(
				':uid' => $object->getUid(),
				':firstName' => $object->getFirstName(),
				':lastName' => $object->getLastName(),
				':email' => $object->getEmail(),
				':password' => $object->getPassword(),
				':salt' => $object->getSalt(),
				':accountType' => $object->getAccountType(),
				':slug' => $object->getSlug()
			)
		);

		return $this->pdo->execute();
	}
}