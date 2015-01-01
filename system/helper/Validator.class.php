<?php namespace System\Helper;

class Validator
{
	//the list of regex string to be used
	//for validation testing
	private $regex = Array(
		'alpha'			=>	'/^[a-zA-Z]+$/',
		'alphaText'		=>	'/^[a-zA-Z ]+$/',
		'alphaNumeric'	=>	'/^[a-zA-Z0-9]+$/',
		'alphaNumText'	=>	'/^[a-zA-Z0-9 ]+$/',
		'booleanInt'	=>	'/^[0-1]+$/',
		'html'			=>	"/^[A-Za-z0-9_~\-!<>.?,@'#\$%\^&\*\(\)]+$/",
		'email' 		=>	'/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/',
		'text'			=>	'/^[a-zA-Z0-9.,?\-_ ():!\'%\\"\/$\n]+$/',
		'int' 			=>	'/^[0-9]+$/',
		'uuid'			=>	'/^[a-zA-Z0-9]{8,8}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{12,12}$/',
		'urlParam'		=>	'/^[a-zA-Z0-9 .\-_]+$/'
	);


	/**
	 *	Validates a given value according to a given
	 *	validation type. All values are required by
	 *	default (they can't be null,false, or empty).
	 *
	 *	@param mixed $toValidate - the value to be tested
	 *	@param String $validationParam - the type of validation to be executed
	 *	@param boolean $is_required - is the value required?
	 *								(if false, the value will bypass regex testing if
	 *								 it is false, null, or empty)
	 */
	public function validate($toValidate,$validationParam,$is_required = true)
	{
		$toValidate = trim($toValidate);
		
		if(!$this->isRequired($is_required,$toValidate))
		{
			return true;
		}

		if($this->match($validationParam,$toValidate))
		{
			return true;
		}

		return false;
	}


	/**
	 *	Validate a group of values
	 *
	 *	@param Array $items - the values to be validated
	 *		Allowed array values:
	 *			- @param Mixed value - the value of the item
	 *			- @param String validateBy - specifies type of validation (Default: type)
	 *			- @param String param - the regex to be used in validation (for 'type' validation only)
	 *			- @param boolean isRequired - is the field required / may it return false, null, or empty? (Default: true)
	 *			- @param int low - low end of range (for 'range' validation only)
	 *			- @param int high - high end of range (for 'range' validation only)
	 *	@var Array $errors - list of errors from validation
	 *	@return mixed (true || Array $errors)
	 */
	public function validateGroup(Array $items, $obj)
	{
		$errors = array();
		$allowedParams = array('value','param','validateBy','isRequired','low','high','error');

		foreach($items as $k => $v)
		{
			foreach($allowedParams as $param)
			{
				if(!isset($v[$param]))
				{
					$v[$param] = null;
				}
			}

			if(!isset($v['error']))
			{
				$v['error'] = 'Invalid Value for \'' . $k . '\'';
			}


			switch($v['validateBy'])
			{
				case 'type':
					if(!$this->validate($v['value'],$v['param'],$v['isRequired']))
					{
						$obj->addError($v['error']);
					}

					break;
				case 'range':
						if(!$this->range($v['low'],$v['high'],$v['value']))
						{
							$obj->addError($v['error']);
						}
					break;
				default:
					$obj->addError($v['error']);
					break;
			}
		}

	
		if(count($errors) > 0)
		{
			return $errors;
		}

		return true;
	}



	/**
	 *	Checks if the given subject is required or not.
	 *	This method will return false if the $bool param
	 *	is false AND the $subject is null, false, or empty.
	 *	Otherwise, it will return true.
	 *	
	 *	This allows non-required subjects to be tested if they
	 *	have a value.
	 *
	 *	@param Boolean $bool - is the subject required?
	 *	@param mixed $subject - the value to be tested
	 *	@return boolean
	 */
	private function isRequired($bool,$subject)
	{
		if(!$bool && (is_null($subject) || !$subject || empty($subject)))
		{
			return false;
		}

		return true;
	}


	/**
	 *	Compares the $subject to a regex $pattern.
	 *
	 *	@param String $pattern - the regex pattern
	 *	@param mixed  $subject - the value to be tested
	 *	@return boolean
	 */
	private function match($pattern,$subject)
	{
		if(isset($this->regex[$pattern]))
		{
			if(preg_match($this->regex[$pattern], $subject))
			{
				return true;
			}
		}

		return false;
	}


	/**
	 *	Sanitizes a given value depending on its type.
	 *
	 *	@param mixed $item - the value to be sanitized
	 *	@param String - the data type of the given value
	 */
	public function sanitize($item, $type = null)
	{
		if($item == null)
		{
			return $item;
		}

		$flag = null;

		switch($type)
		{
			case 'email':
				$filter = FILTER_SANITIZE_EMAIL;
				break;
			case 'int':
				$filter = FILTER_SANITIZE_NUMBER_INT;
				break;
			case 'float':
				$filter = FILTER_SANITIZE_NUMBER_FLOAT;
				$flag = FILTER_FLAG_ALLOW_FRACTION;
			case 'url':
				$filter = FILTER_SANITIZE_URL;
				break;
			case 'special':
				$filter = FILTER_SANITIZE_SPECIAL_CHARS;
				break;
			case 'string':
			default:
				$filter = FILTER_SANITIZE_STRING;
				break;
		}

		return filter_var($item,$filter,$flag);
	}


	/**
	 * Sanitize multiple values at once
	 *
	 *	@param Array $items - the array of values to be santized
	 *	@return Array (returns sanitized values in an array)
	 */
	public function sanitizeGroup(Array $items)
	{
		$sanitizedValues = array();

		foreach($items as $i => $v)
		{
			$sanitizedValues[$i] = $this->sanitize($v);
		}

		debug_dump($sanitizedValues);
		return $sanitizedValues;
	}


	/**
	 *	Check if a value is within a given range (inclusive)
	 *
	 *	@param int $low - the low end of the range
	 *	@param int $high - the high end of the range
	 *	@param int $value - the value to be tested
	 *	@return boolean
	 */
	public function range($low,$high,$value)
	{
		if($value < $low || $value > $high)
		{
			return false;
		}

		return true;
	}
}