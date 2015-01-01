$(document).ready(function(){
	regex = {
		'alpha'			:	'^[a-zA-Z]+$',
		'alphaText'		:	'^[a-zA-Z ]+$',
		'alphaNumeric'	:	'^[a-zA-Z0-9]+$',
		'base64'		:	'^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{4}|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)$',
		'email' 		:	'[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}',
		'html'			:	'^[a-zA-Z0-9.,?:\'!;\'"\\<>/()&\-_ %\n]+$',
		'int' 			:	'^[0-9]+$',
		'uuid'			:	'^[a-zA-Z0-9]{8,8}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{4,4}[-]{1,1}[a-zA-Z0-9]{12,12}$',
		'urlParam'		:	'^[a-zA-Z0-9 .\-_]+$',
		'timestamp'		:	'^[0-9]{4,4}[-]{1,1}[0-9]{2,2}[-]{1,1}[0-9]{2,2}[ ]{1,1}[0-9]{2,2}[:]{1,1}[0-9]{2,2}[:]{1,1}[0-9]{2,2}$',
		/*'text'			:	'^[a-zA-Z0-9.?,\n\-_ ()!%\\\'"\/$]+$'*/
		'text'			:	'^[a-zA-Z0-9.,?:\'!;\'"/()&\-_ %\n]+$'
	};
});

function validate(toValidate,validationParam,is_required)
{
	if(!isRequired(is_required,toValidate))
	{
		return true;
	}

	if(matchPattern(validationParam,toValidate))
	{
		return true;
	}

	return false;
}


function isRequired(is_required,toValidate)
{
	toValidate = $.trim(toValidate);

	if(!is_required && (toValidate == '' || !toValidate || toValidate == 'undefined'))
	{
		return false;
	}

	return true;
}


function matchPattern(pattern,subject)
{
	if(regex.hasOwnProperty(pattern))
	{
		regex[pattern] = new RegExp(regex[pattern]);
		if(regex[pattern].test(subject))
		{
			return true;
		}
	}
	
	return false;
}


function hasPlaceholder(element)
{
	if(typeof element.attr('placeholder') == 'undefined' || element.attr('placeholder') == false)
	{
		return true;
	}

	return false;
}


function hasErrors()
{
	if($('.alert-danger').length > 0)
	{
		return true;
	}

	return false;
}


function validateRange(low,high,value)
{
	if(value < low || value > high)
	{
		return false;
	}

	return true;
}


function validateInArray(value,array)
{
	if($.inArray(value,array) == -1)
	{
		return false;
	}

	return true;
}


function validateIsArrayKey(value,array)
{
	if(!(value in array))
	{
		return false;
	}

	return true;
}