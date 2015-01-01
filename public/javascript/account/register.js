var accountRegisterForm = $('[data-form="accountRegister"]');
var accountRegisterFirstName = $('input[name="accountRegisterFirstName"]');
var accountRegisterLastName = $('input[name="accountRegisterLastName"]');
var accountRegisterEmail = $('input[name="accountRegisterEmail"]');
var accountRegisterPassword = $('input[name="accountRegisterPassword"]');
var accountRegisterConfirmPassword = $('input[name="accountRegisterConfirmPassword"]');
var accountRegisterSubmit = $('input[type="submit"][name="accountRegisterSubmit"]');

accountRegisterSubmit.click(function(e)
{
	e.preventDefault();
	resetForm();
	
	accountRegisterValidate();

	if(hasErrors())
	{
		return false;
	}

	var data = {
		'firstName':accountRegisterFirstName.val(),
		'lastName':accountRegisterLastName.val(),
		'email':accountRegisterEmail.val(),
		'password':accountRegisterPassword.val(),
		'confirmPassword':accountRegisterConfirmPassword.val()
	};

	xhrSaveAccount(accountRegisterForm,data);
});


function accountRegisterValidate()
{
	if(!validate(accountRegisterFirstName.val(),'alphaText',true))
	{
		writeMessage(accountRegisterForm,'danger','Please enter a valid first name');
	}

	if(!validate(accountRegisterLastName.val(),'alphaText',true))
	{
		writeMessage(accountRegisterForm,'danger','Please enter a valid last name');
	}

	if(!validate(accountRegisterEmail.val(),'email',true))
	{
		writeMessage(accountRegisterForm,'danger','Please enter a valid email');
	}

	if(!validate(accountRegisterPassword.val(),'alphaNumeric',true))
	{
		writeMessage(accountRegisterForm,'danger','Your password may only container alpha-numeric characters');
	}

	if(!validate(accountRegisterPassword.val(),'alphaNumeric',true))
	{
		writeMessage(accountRegisterForm,'danger','Your password may only container alpha-numeric characters');
	}

	if(accountRegisterPassword.val() != accountRegisterConfirmPassword.val())
	{
		writeMessage(accountRegisterForm,'danger','Both passwords must match');	
	}
}


function accountRegisterRedirect()
{
	var url = getRoot();
	setRedirectCountdown(2,url,null);
}