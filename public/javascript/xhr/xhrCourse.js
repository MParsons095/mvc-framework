function xhrSaveCourse(container,data)
{
    var responseMessages = {
        'success':'Course Saved',
        'error':'Failed to Save Course'
    };

    var funcExec = {};
    xhrLoad('xhrCrud/course/save',container,data,responseMessages,funcExec);
}


function xhrDeleteCourse(container,data)
{
    var responseMessages = {
        'success':'Course Deleted',
        'error':'Failed to Delete Course'
    };

    var funcExec = {};

    xhrLoad('xhrCrud/course/delete',container,data,responseMessages,funcExec);
}