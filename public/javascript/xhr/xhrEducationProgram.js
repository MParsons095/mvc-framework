function xhrSearch(container,data,execFunc)
{
    var responseMessages = {
        'success':false,
        'error':false
    }

    xhrLoad('xhrCrud/educationProgram/search',container,data,responseMessages,execFunc);
}