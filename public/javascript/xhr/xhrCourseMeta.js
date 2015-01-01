function xhrDeleteCourseMeta(container,data)
{
    var responseMessages = {
        'success': 'Item Deleted',
        'error':'Failed to deleted item. Please refresh and try again.'
    };

    xhrLoad('xhrCrud/courseMeta/delete',container,data,responseMessages,null);
}


function xhrSaveCourseMeta(container,data,execFunc)
{
    var responseMessages = {
        'success':'Item Saved',
        'error':'Failed to update item'
    }

    xhrLoad('xhrCrud/courseMeta/save',container,data,responseMessages,execFunc);
}


function xhrGetCurriculumByParent(container,data,execFunc)
{
    var responseMessages = {
        'success':'Curriculum Listing Reloaded',
        'error':'Failed to Reload Curriculum Listing'
    }

    xhrLoad('xhrCrud/courseMeta/getCurriculumByParent',container,data,responseMessages,execFunc);
}