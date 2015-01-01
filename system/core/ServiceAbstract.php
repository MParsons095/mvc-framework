<?php namespace System\Core;

use \System\ClassInterface\Validator,
	\Exception;

abstract class ServiceAbstract implements Validator
{
	protected $mapper;
	protected $returnErrors;
	protected $successMessages;
	protected $errorMessages;
	protected $requiredFields;

	

	public function __construct()
	{
		$this->returnErrors = true;
		$this->successMessages = array();
		$this->errorMessages = array();
		$this->validator = load_class('Validator','system/helper');
		$this->hash = load_class('Hash','system/helper');
		$this->session = load_class('Session','system/library');

	}


	public function hasValidUid($data)
	{
		$uid = $this->validator->sanitize($data);

		if(!$this->validator->validate($uid,'uuid'))
		{
			$this->addError('Invalid Unique ID provided');
			return false;
		}

		return $uid;
	}


	public function verifyData($data, $fields)
	{
		if(!isset($data['uid']) || !$data['uid'])
		{
			$data['uid'] = null;
			array_push($fields, 'uid');
		}
		else
		{
			$this->hasValidUid($this->validator->sanitize($data['uid']));
		}

		foreach($fields as $field)
		{
			if(!array_key_exists($field,$data))
			{
				$this->addError('Error Processing Request: Missing Data');
				return false;
			}
		}

		return $data;
	}


	public function setMapper(MapperAbstract $mapper)
	{
		$this->mapper = $mapper;
		$this->setObject($this->mapper->create());
	}


	public function setObject(DomainObjectAbstract $object)
	{
		$this->object = $object;
	}


	protected function verifyMapper()
	{
		try
		{
			if($this->mapper == null)
			{
				throw new Exception('ServiceAbstract::verifyMapper failure. No mapper found.');
			}

			return true;
		}
		catch(Exception $e)
		{
			log_internal_error($e);
			load_internal_error('Class Not Found. Please contact an administrator.');
			return false;
		}
	}


	protected function verifyObject()
	{
		try
		{
			if($this->object == null)
			{
				throw new Exception('ServiceAbstract::verifyObject failure. No object found.');
			}

			return true;
		}
		catch(Exception $e)
		{
			log_internal_error($e);
			load_internal_error('Class Not Found. Please contact an administrator.');
			return false;
		}
	}


	public function hasErrors()
	{
		if(count($this->errorMessages) > 0)
		{
			return true;
		}

		return false;
	}


	public function addError($message)
	{
		if($message == null)
		{
			$this->returnErrors = false;
			return;
		}

		$this->errorMessages[] = $message;
	}



	public function addSuccess($message)
	{
		$this->successMessages[] = $message;
	}


	public function getResponse()
	{
		$response = array();


		if(count($this->errorMessages) > 0)
		{
			$response['state'] = false;
			if($this->returnErrors)
			{
				$response['response'] = $this->errorMessages;
			}
			else
			{
				$response['response'] = array();
			}
		}
		else
		{
			$response['state'] = true;
			$response['response'] = $this->successMessages;
		}

		$this->successMessages = array();
		$this->errorMessages = array();
		return $response;
	}
}