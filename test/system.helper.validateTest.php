<?php
include '../system/core/testingEnvironment.php';
include '../system/helper/Validator.class.php';

$Validator = new \System\Helper\Validator();


function validateValidAlphaText($Validator)
{
	$result = 'validAlphaText: ';

	if($Validator->validate('lorem ipsum','alphaText'))
	{
		$result .= 'true';
	}
	else
	{
		$result .= 'false';
	}

	print $result . '<br />';
}


function sanitizeNullUuid($Validator)
{
	$_POST['uid'] = null;
	$result = 'sanitizeString: ';

	print 'sanitizeString: ';
	print getType($Validator->sanitize($_POST['uid'],'uuid'));
	print '<br />';

	$_POST = array();
}


function validateEmptyString($Validator)
{
	if($Validator->validate('','text',true))
	{
		$string = 'true';
	}
	else
	{
		$string = 'false';
	}

	print 'validateEmptyString: ' . $string;
}


function validateValidBooleanInt($Validator)
{
	if($Validator->validate(1,'booleanInt'))
	{
		print 'true';
	}
	else
	{
		print 'false';
	}
}


function validateInvalidBooleanInt($Validator)
{
	if($Validator->validate(2,'booleanInt'))
	{
		print 'true';
	}
	else
	{
		print 'false';
	}
}


function validateInvalidBooleanIntWithString($Validator)
{
	if($Validator->validate(2,'booleanInt'))
	{
		print 'true';
	}
	else
	{
		print 'false';
	}
}


function validateValidUuid($Validator)
{
	if($Validator->validate('bb017f9b-b4ed-11e3-a562-88ae1de0dfc2','uuid'))
	{
		print 'true';
	}
	else
	{
		print 'false';
	}
}

validateValidUuid($Validator);