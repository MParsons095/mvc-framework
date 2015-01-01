<?php namespace Application\Model;

use \System\Core\ServiceAbstract,
	\System\Core\MapperAbstract,
	\System\Core\DomainObjectAbstract;

class CourseMetaModel extends ServiceAbstract
{
	
	public function __construct()
	{
		parent::__construct();
	}



	public function getCurriculum($data)
	{
		if(!isset($data['uid']) || $data['uid'] == '')
		{
			$this->addError('Error Processing Request: Missing Data');
			return false;
		}

		$uid = $this->validator->sanitize($data['uid']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Uuid Sent');
			return;
		}

		$query = $this->mapper->select(array(
			'where' => array(':courseId' => $uid,':type' => 'curriculum'),
			'orderBy' => array('value' => 'ASC')
		));

		if(is_string($query))
		{
			$this->addError($query);
			return false;
		}

		$this->addSuccess($query);

		$objList = array();
		foreach($query as $item)
		{
			$obj = $this->mapper->create();
			$this->mapper->populate($obj,$item);
			$objList[] = $obj;
			$obj = null;
		}

		return  $objList;
	}


	public function getRequirements($data)
	{
		if(!isset($data['uid']) || $data['uid'] == '')
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}

		$uid = $this->validator->sanitize($data['uid']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Uuid Sent');
			return;
		}

		$query = $this->mapper->select(array(
			'where' => array(':courseId' => $uid,':type' => 'requirement'),
			'orderby' => array('timestamp' => 'ASC'),
		));

		if(is_string($query))
		{
			$this->addError($query);
			return $query;
		}

		$this->addSuccess($query);

		$objList = array();
		foreach($query as $requirement)
		{
			$obj = $this->mapper->create();
			$this->mapper->populate($obj,$requirement);
			$objList[] = $obj;
		}

		return $objList;
	}


	public function getCurriculumByParent($data)
	{
		if(!isset($data['childOf']) || $data['childOf'] == '')
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}

		$uid = $this->validator->sanitize($data['childOf']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Uuid Sent');
			return;
		}

		$query = $this->mapper->select(array(
			'where' => array(':childOf' => $uid,':type' => 'curriculum'),
			'orderby' => array('timestamp' => 'ASC')
		));

		if(is_string($query))
		{
			$this->addError($query);
			return;
		}

		$this->addSuccess($query);

		$objList = array();
		foreach($query as $item)
		{
			$obj = $this->mapper->create();
			$this->mapper->populate($obj,$item);
			$objList[] = $obj;
			$obj = null;
		}
		return  $objList;
	}

	public function selectCourseMetaByType($data)
	{/*
		$query = $this->mapper->select(array(
			'groupBy' => array('type'),
			'where' => array(':courseId' => $uid),
			'orderby' => array('timestamp' => 'ASC')
		));

		if(is_string($query))
		{
			$this->addError($query);
			return;
		}

		$this->addSuccess($query);
		*/
	}


	public function selectSingle($data)
	{
		if(!isset($data['uid']) || $data['uid'] == '')
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}

		$uid = $this->validator->sanitize($data['uid']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Uuid Sent');
			return;
		}

		$query = $this->mapper->select(array(
			'where' => array('uid' => $uid),
		));

		if(is_string($query))
		{
			$this->addError($query);
			return;
		}

		$this->addSuccess($query);
	}


	public function selectAll()
	{
		$query = $this->mapper->selectAll();

		if(is_string($query))
		{
			$this->addError($query);
			return false;
		}

		$this->addSuccess($query);
		return true;
	}


	public function selectWhere($data)
	{
		$this->verifyMapper();
		if(!isset($data['courseId']) || $data['courseId'] == '')
		{
			$this->addError('Error Processing Request: Missing Data');
			return;
		}

		$uid = $this->validator->sanitize($data['courseId']);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Uuid Sent');
			return;
		}


		$query = $this->mapper->select(
			array(
				'where' => array(':courseId' => $uid),
				'orderby' => array('timestamp' => 'ASC')
			)
		);

		if(is_string($query))
		{
			$this->addError($query);
			return;
		}

		$this->addSuccess($query);
	}


	public function save($data)
	{
		if(!isset($data['uid']) || $data['uid'] == '')
		{
			$data['uid'] = null;
		}

		if( !isset($data['courseId']) ||
			!isset($data['type']) ||
			!isset($data['value']) ||
			!isset($data['isRequired']) ||
			!isset($data['childOf'])
			)
		{
			$this->addError('Error Processing Request: Missing Data');
			$this->addError($data);
			return;
		}

		if($data['uid'] != null)
		{
			$this->object->setUid($this->validator->sanitize($data['uid']));
		
			if(!$this->validator->validate($this->object->getUid(),'uuid'))
			{
				$this->addError('Error: Item Doesn\'t Exist');
			}
		}

		$this->object->setCourseId($this->validator->sanitize($data['courseId']));
		$this->object->setType($this->validator->sanitize($data['type']));
		$this->object->setValue($this->validator->sanitize($data['value']));
		$this->object->setIsRequired($this->validator->sanitize($data['isRequired']));
		$this->object->setChildOf($this->validator->sanitize($data['childOf']));

		if(!$this->validator->validate($this->object->getCourseId(),'uuid'))
		{
			$this->addError('Invalid Course ID Provided');
		}

		if(!$this->validator->validate($this->object->getType(),'alphaText'))
		{
			$this->addError('Unexpected value submitted. Please refresh the page and try again.');
		}

		if(!$this->validator->validate($this->object->getValue(),'text'))
		{
			$this->addError('Illegal characters found in \'Value\'');
		}

		if(!$this->validator->validate($this->object->getIsRequired(),'booleanInt'))
		{
			$this->addError('Unexpected value given for \'Required\'');
		}

		if(!$this->validator->validate($this->object->getChildOf(),'uuid') && $this->object->getChildOf() != 0)
		{
			$this->addError('Unexpected value given for \'Child\'');
		}

		if(count($this->errorMessages) > 0)
		{
			return;
		}

		$query = $this->mapper->save($this->object);

		if(is_string($query))
		{
			$this->addError($query);
			return; 
		}
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
}