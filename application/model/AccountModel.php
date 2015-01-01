<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class AccountModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function findByUid($uid)
	{
		$this->verifyMapper();
		return $this->mapper->findByUid($this->hasValidUid($uid));
	}

	public function findBySlug($data)
	{
		$this->verifyMapper();

		if(!isset($data['slug']))
		{
			$this->addError('Account slug not found');
			return false;
		}

		$slug = $this->validator->sanitize($data['slug']);

		if(!$this->validator->validate($slug,'urlParam'))
		{
			$this->addError('Invalid Account Slug');
			return false;
		}

		$this->mapper->pdo->query('SELECT * FROM account WHERE slug = :slug',array(':slug' => $slug));
		$result = $this->mapper->pdo->single();

		if(is_string($result))
		{
			$this->addError($result);
			return false;
		}

		$this->addSuccess($result);

		$obj = $this->mapper->create();
		$this->mapper->populate($obj,$result);
		return $obj;
	}


	public function selectAllAccountData()
	{
		$this->mapper->pdo->query(
			'SELECT
				account.uid,
				account.firstName,
				account.lastName,
				account.email,
				account.slug,
				account.accountType,
				account_meta.picture,
				account_meta.bio,
				account_meta.yearJoined
			FROM account
			INNER join
				account_meta
			ON 	account.uid = account_meta.accountUid
			'
		);

		$result = $this->mapper->pdo->results();

		if(is_string($result))
		{
			$this->addError($result);
			return false;
		}

		$this->addSuccess($result);
		return $result;
	}
}