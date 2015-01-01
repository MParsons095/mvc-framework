function xhrSelectAwardsByAccount(container,data,execFunc)
{
	var responseMessages = {
		'success':false,
		'error':'Failed to load awards'
	};
	xhrLoad('XhrCrud/award/selectAll',container,data,responseMessages,execFunc);
}


function xhrSaveAward(container,data,execFunc)
{
	var responseMessages = {
		'success':'Award Saved',
		'error':'Failed to save award'
	};

	xhrLoad('XhrCrud/award/save',container,data,responseMessages,execFunc);
}


function xhrDeleteAward(container,data,execFunc)
{
	var responseMessages = {
		'success':'Award Deleted',
		'error':'Failed to delete award'
	};

	xhrLoad('XhrCrud/award/delete',container,data,responseMessages,execFunc);
}