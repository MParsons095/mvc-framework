<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class CourseModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function save($data)
	{

		if(!isset($data['uid']) || $data['uid'] == '')
		{
			$data['uid'] = null;
		}

		if( !isset($data['title']) ||
			!isset($data['caption']) ||
			!isset($data['description']) ||
			!isset($data['credit'])
			)
		{
			$this->addError('Error Processing Request: Missing Data');
			$this->addError($data);
			return;
		}

		$this->object->setUid($this->validator->sanitize($data['uid']));
		$this->object->setTitle($this->validator->sanitize($data['title']));
		$this->object->setSlug(str_replace(' ', '-', $this->object->getTitle()));
		$this->object->setCaption($this->validator->sanitize($data['caption']));
		$this->object->setDescription($this->validator->sanitize($data['description']));
		$this->object->setCredit($this->validator->sanitize($data['credit']));

		if(!$this->validator->validate($this->object->getUid(),'uuid') && $this->object->getUid() != null)
		{
			$this->addError('Invalid Unique ID Provided');
		}

		if(!$this->validator->validate($this->object->getTitle(),'alphaText'))
		{
			$this->addError('Illegal characters found in title');
			$this->addError($this->object->getTitle());
		}

		if(!$this->validator->validate($this->object->getCaption(),'text',false))
		{
			$this->addError('Illegal characters found in caption');
		}

		if(!$this->validator->validate($this->object->getDescription(),'text'))
		{
			$this->addError('Illegal characters found in description');
		}

		if(!$this->validator->validate($this->object->getCredit(),'int'))
		{
			$this->addError('Credit must be an integer');
		}

		if(count($this->errorMessages) > 0)
		{
			$this->addError($data);
			return;
		}


		$query = $this->mapper->save($this->object);

		if(is_string($query))
		{
			$this->addError($query);
			return; 
		}
		$this->addSuccess('Course Successfully Added!');
	}


	public function delete($data)
	{
		if(!isset($data['uid']))
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}


		$uid = $this->validator->sanitize($data['uid']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Incorrect Data Sent. Please refresh the page and try again.');
			$this->addError($uid);
			return false;
		}

		$this->object->setUid($uid);

		return $this->mapper->delete($this->object);
	}


	public function getCourse($slug)
	{
		$slug = $this->validator->sanitize($slug,'url');

		if(!$this->validator->validate($slug,'urlParam'))
		{
			return false;
		}


		return $this->mapper->findBySlug($slug);
	}


	public function getAllCourses()
	{
		$this->mapper->pdo->query('SELECT * FROM `course`');
		$courses = array();
		$results = $this->mapper->pdo->results();
		
		if(!is_array($results) || count($results) == 0)
		{
			$this->addError('No Course Found');
			return null;
		}

		foreach($results as $course)
		{
			$temp = $this->mapper->create();
			$this->mapper->populate($temp,$course);
			$courses[] = $temp;
		}

		$this->addSuccess($results);
		return $courses;
	}
}