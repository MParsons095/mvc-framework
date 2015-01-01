function xhrSaveAccount(container,data)
{
	var responseMessages = {
		'success' : 'Registration Complete! Redirecting to home page... <br /><b>Click "Login" on the upper right after you are redirected.',
		'error' : 'Failed to Register. Please Try again.'
	};

	var execFunc = {
		'success': accountRegisterRedirect
	};

	xhrLoad('xhrCrud/account/save',container,data,responseMessages,execFunc);
}