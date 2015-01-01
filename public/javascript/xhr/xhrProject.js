function xhrLoadByAccountProjects(container,data,execFunc)
{
	var responseMessages = {
		'success': false,
		'error': 'Failed to load Projects'
	}

	xhrLoad('xhrCrud/project/selectByAccount',container,data,responseMessages,execFunc);
}


function xhrSaveProject(container,data,execFunc)
{
	var responseMessages = {
		'success'	: 'Project Created',
		'error'		: 'Failed to create project'
	}

	xhrLoad('xhrCrud/project/save',container,data,responseMessages,execFunc);
}