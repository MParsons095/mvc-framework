var courseCurriculumContainer = $('#courseCurriculum');
var courseMetaIsRequired = $('input[name="courseMetaIsRequired"]');
var courseMetaDeleteButton = $('[data-action="deleteCourseMeta"]');
var courseMetaSaveButton = $('[data-action="addCourseMeta"]');
var saveCourseCurriculumButton = $('[data-action="saveCourseCurriculum"]');

/**
 *  Save Course Curriculum
 */
saveCourseCurriculumButton.click(function(e){
    e.preventDefault();
    resetForm();

    var modal = $('#addCourseCurriculumModal .modal-body');
    var container = $('#courseCurriculum');
    var uid = null;
    var courseId = courseData['uid'];
    var childOf = $('select[name="courseCurriculumChildOf"]');
    var type = 'curriculum';
    var value = $('textarea[name="addCourseCurriculumValue"]');
    var isRequired = 1;

    if(!validate(courseId,'uuid',true))
    {
        writeMessage(modal,'danger','Invalid Data Sent: Please refresh and try again');
    }

    if(!validate(value.val(),'text',true))
    {
        writeMessage(modal,'danger','\Value\' field must only contain alphabetic, numeric, and punctuation characters');
    }

    if(!validate(childOf.val(),'uuid',true) && childOf.val() != 0)
    {
        writeMessage(modal,'danger','Curriculum item must be a parent or a child of an existing curriculum item');
    }

    if(hasErrors())
    {
        return false;
    }

    data = {
        'uid':uid,
        'courseId':courseId,
        'childOf':childOf.val(),
        'isRequired':isRequired,
        'value':value.val(),
        'type':type
    };

    execFunc = {
       // 'success':loadCourseCurriculum
    };

    xhrSaveCourseMeta(container,data,execFunc);
});


function appendCourseCurriculum(xhr)
{
    var parent = {};
    var child = {};

    console.log('----------------');
    //console.log(xhr.response[0]);

    for(i = 0; i < xhr.response[0].length; i++)
    {
        if(!xhr.response[0][i]['childOf'])
        {
            parent.push(xhr.response[0][i]);
        }
        else
        {
            child.push(xhr.response[0][i]);
        }
    }

    console.log('--------------------');
    console.log(parent);
    console.log(child);
    console.log('--------------------');
}

function loadCourseCurriculum()
{
    alert('loading curriculum')
    var data = {
        'uid':courseData['uid'],
    };

    var responseMessages = {
        'success':'Listing Reloaded',
        'error':'Failed to Reload Requirement Listing'
    };

    var execFunc = {
        'success':appendCourseCurriculum
    };

    setTimeout(function(){
        resetForm();
        xhrLoad('xhrCrud/courseMeta/selectCurriculum',courseCurriculumContainer,data,responseMessages,execFunc);
    },1500);
}


/**
 *  Save Course Meta
 */
courseMetaSaveButton.click(function(e){
    e.preventDefault();
    resetForm();

    var modal = $('#addCourseRequirementModal');
    var container = $('#courseRequirements');
    var uid = null;
    var courseId = courseData['uid'];
    var childOf = 0;
    var type = 'requirement';
    var value = $('textarea[name="addCourseMetaValue"]').val();
    var isRequired = $('input[type="checkbox"][name="addCourseMetaRequired"]');

    if(isRequired.is(':checked'))
    {
        isRequired = 1;
    }
    else
    {
        isRequired = 0;
    }

    var data = {
        'uid':uid,
        'courseId':courseId,
        'childOf':childOf,
        'isRequired':isRequired,
        'value':value,
        'type':type
    };


    if(!validate(courseId,'uuid',true))
    {
        writeMessage(container,'danger','Error Processing Request: Data Missing.');
    }

    if(!validate(value,'text',true))
    {
        writeMessage(container,'danger','Invalid input in \'value\' field');
    }

    if(hasErrors())
    {
        return false;
    }

    xhrSaveCourseMeta(container,data);


    if(!hasErrors())
    {
        modal.modal('hide');
    }

    setTimeout(function(){
        loadCourseRequirements(container);
    },2000);
});


function loadCourseRequirements(container)
{
    resetForm();
    writeMessage(container,'info','Reloading List...');

    var data = {
        'uid':courseData['uid'],
    };

    var responseMessages = {
        'success':'Listing Reloaded',
        'error':'Failed to Reload Requirement Listing'
    };

    var execFunc = {
        'success':appendCourseRequirements
    };

    setTimeout(function(){
        resetForm();
        xhrLoad('xhrCrud/courseMeta/selectRequirements',container,data,responseMessages,execFunc);
    },1500);
}

/** 
 *  Delete Course Meta
 */
$('#courseRequirementsContent > tbody').on('click','button[data-action="deleteCourseMeta"]',function(e){
    e.preventDefault();
    resetForm();

    uid = $(this).attr('data-id');
    parentRow = $(this).closest('tr');
    container = $('#courseRequirements');

    xhrDeleteCourseMeta(container,{'uid':uid});

    if(!hasErrors())
    {
        parentRow.addClass('alert-danger');
        parentRow.fadeOut(1000);

        setTimeout(function(){
            parentRow.remove();
        },1200);
    }
});



/**
 * Update isRequired value
 */
$('#courseRequirementsContent > tbody').on('change','input[name="courseMetaIsRequired"]',function(e) {
    e.preventDefault();
    resetForm();

    if(this.checked)
    {
        var isRequired = 1;
    }
    else
    {
        var isRequired = 0;
    }

    var container = $('#courseRequirements');
    var uid = $(this).attr('data-id');
    var courseUid = courseData['uid'];
    var value = $('input[data-id="' + uid + '"][name="courseMetaValue"]').val();
    var childOf = $('input[data-id="' + uid + '"][name="courseMetaChildOf"]').val();
    var type = $('input[data-id="' + uid + '"][name="courseMetaType"]').val();
    var data = {
        'uid':uid,
        'courseId':courseUid,
        'value':value,
        'childOf':childOf,
        'isRequired':isRequired,
        'type':type
    };
    var responseMessages = {
        'success':'Item Updated',
        'error':'Failed to update item'
    }

    $('input[data-id="' + uid + '"][name="courseMetaIsRequired"]').attr('value',isRequired);

    xhrLoad('xhrCrud/courseMeta/save',container,data,responseMessages,null);
    return false;
});


function appendCourseRequirements(xhr)
{
    var response = xhr.response[0];
    var table = $('[data-action="loadCourseRequirements"]');

    var tableBody = '';

    $(response).each(function(key,requirement){
        tableBody += '<tr>' +
           '<td data-value="value">' + requirement.value +'</td>' +
            '<td data-value="isRequired"><input type="checkbox" data-id="' + requirement.uid + '" name="courseMetaIsRequired" ></td>' +
            '<td>' +
                '<button data-action="deleteCourseMeta" class="btn btn-grey" data-id="' + requirement.uid + '">Delete</button>' +
                '<input type="hidden" name="courseMetaId" value="' + requirement.uid + '" />' +
                '<input type="hidden" name="courseMetaValue" value="this is a test" data-id="' + requirement.uid + '" />' +
                '<input type="hidden" name="courseMetaIsRequired" value="' + requirement.isRequired + '" data-id="' + requirement.uid + '" />' +
                '<input type="hidden" name="courseMetaChildOf" value="' + requirement.childOf + '" data-id="' + requirement.uid + '" />' +
                '<input type="hidden" name="courseMetaType" value="requirement" data-id="' + requirement.uid + '" />' +
            '</td>' +
        '</tr>';
    });

    table.html(tableBody);
}