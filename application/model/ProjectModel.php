<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class ProjectModel extends ServiceAbstract
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

	public function findBySlug($slug)
	{
		$this->verifyMapper();

		if(!isset($slug))
		{
			$this->addError('Slug not found');
			return false;
		}

		$slug = $this->validator->sanitize($slug);

		if(!$this->validator->validate($slug,'urlParam'))
		{
			$this->addError('Invalid Slug');
			return false;
		}

		$this->mapper->pdo->query('SELECT * FROM project WHERE slug = :slug',array(':slug' => $slug));
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


	public function selectByAccount($data)
	{
		$this->verifyMapper();

		if(!isset($data['accountUid']))
		{
			$this->addError('Internal Error: Missing Data');
			return false;
		}


		$accountUid = $this->validator->sanitize($data['accountUid']);

		if(!$this->validator->validate($accountUid,'uuid'))
		{
			$this->addError('Invalid Account ID');
			return false;
		}

		$this->mapper->pdo->query('
			SELECT *
			FROM project_meta
			WHERE accountUid = :accountUid
		',array(':accountUid' => $accountUid));
		$accountProjects = $this->mapper->pdo->results();

		if(is_array($accountProjects) && count($accountProjects) > 0)
		{
			$projects = array();

			foreach($accountProjects as $project)
			{
				$this->mapper->pdo->query('
					SELECT *
					FROM project
					WHERE uid = :uid
					',
					array(':uid' => $project['projectUid'])
				);
				
				$result = $this->mapper->pdo->single();

				if(is_array($result) && count($result) > 0)
				{
					array_push($projects, $result);
				}
			}
		}
		else
		{
			$this->addError(null);
			return false;
		}

		$this->addSuccess($projects);
		return $projects;
	}


	public function selectAll()
	{
		$result = $this->mapper->selectAll();

		if(is_string($result))
		{
			$this->addError($result);
			return false;
		}

		$objArray = array();

		foreach($result as $project)
		{
			$obj = $this->mapper->create();
			$this->mapper->populate($obj,$project);
			$objArray[] = $obj;
		}

		$this->addSuccess($result);
		return $objArray;
	}


	public function save($data)
	{
		$this->verifyMapper();

		if(!isset($data['uid']))
		{
			$data['uid'] = null;
		}

		if( !isset($data['author']) ||
			!isset($data['title']) ||
			!isset($data['description']) ||
			!isset($data['picture'])
			)
		{
			$this->addError('Internal Error: Missing Data');
		}

		$object = $this->mapper->create();
		$object->setAuthor($this->validator->sanitize($data['author']));
		$object->setTitle($this->validator->sanitize($data['title']));
		$data['description'] = str_replace('\'', '&#39', $data['description']);
		$object->setDescription($this->validator->sanitize(html_entity_decode(urldecode($data['description']))));
		$object->setPicture($this->validator->sanitize($data['picture']));
		$object->setSlug(str_replace(' ', '-', $object->getTitle()));

		if(!$this->validator->validate($object->getAuthor(),'uuid'))
		{
			$this->addError('Internal Error: Invalid Account ID. Please Refresh and Try Again');
		}

		if(!$this->validator->validate($object->getTitle(),'text'))
		{
			$this->addError('Invalid Title (Only Alphabetic Characters Allowed)');
		}

		if(!$this->validator->validate($object->getDescription(),'html'))
		{
			$this->addError('Invalid Description (Only Alphabetic,Numeric, and Punctuation Characters Allowed)');
		}

		if(!$this->validator->validate($object->getPicture(),'alphaNumeric'))
		{
			$this->addError('Invalid File Name for Picture');
		}

		if($this->hasErrors())
		{
			return false;
		}

		$this->mapper->pdo->query('SELECT COUNT(*) FROM project WHERE slug = :slug',array(':slug' => $object->getSlug()));
		$this->mapper->pdo->execute();

		if($this->mapper->pdo->count() > 0)
		{
			$object->setSlug($object->getSlug() . '-' . ($this->mapper->pdo->count() + 1));
		}


		//move project image
		$picturePath = SERVER_ROOT . 'public/temp/image/' . $object->getPicture() . '.jpg';

		try
		{
			$systemImagePath = SERVER_ROOT . 'public/system/image';

			if(!file_exists($systemImagePath))
			{
				mkdir($systemImagePath, 0777, true);
			}

			if(!is_file($picturePath) || !rename($picturePath,$systemImagePath . '/' . $object->getPicture() . '.jpg'))
			{
				$this->addError('Failed to process profile picture. Please refresh and try again.');
				return false;
			}
		}
		catch(\Exception $e)
		{
			$this->addError('Failed to process profile picture. Please refresh and try again.');
			return false;
		}


		$return = $this->mapper->save($object);
		if(is_string($return))
		{
			$this->addError($return);
			return false;
		}

		$this->addSuccess('Project Saved');

		$this->addAuthor($object->getAuthor(),$object->getTitle());
		return true;
	}



	public function addAuthor($author,$projectTitle)
	{
		$uid = $this->mapper->pdo->uuid();

		$this->mapper->pdo->query('
			INSERT INTO project_meta(uid,projectUid,accountUid,role)
			VALUES(
				:uid,
				(SELECT uid FROM project WHERE title = :title),
				:author,
				"author"
			)
		',array(':uid' => $uid,':author' => $author,':title' => $projectTitle));
		$this->mapper->pdo->execute();
	}


	public function delete($data)
	{
		$this->verifyMapper();
		$uid = $this->hasValidUid($data['uid']);

		if(!$uid)
		{
			return false;
		}

		$object = $this->mapper->create();
		$object->setUid($uid);
		$result = $this->mapper->delete($object);

		if(is_string($result))
		{
			$this->addError($result);
			return false;
		}

		$this->addSuccess('Project Deleted');
		return true;
	}
}