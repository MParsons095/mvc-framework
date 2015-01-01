var courseContainer = $('[data-role="courseContainer"]')
var courseDeleteButton = $('[data-action="delete-course"]');
var courseSaveSubmit = $('input[name="saveCourse"]');


/**
 *	Save Course
 */
 courseSaveSubmit.click(function(e){
 	e.preventDefault();
 	resetForm();

 	var courseTitle = $('input[name="courseTitle"]');
    var courseCaption = $('textarea[name="courseCaption"]');
    var courseCredit = $('input[name="courseCredit"]');
    var courseDescription = $('textarea[name="courseDescription"]');
    var container = $('[data-form="saveCourse"]');

    var data = {
        'uid':courseData['uid'],
        'title':courseTitle.val(),
        'caption':courseCaption.val(),
        'description':courseDescription.val(),
        'credit':courseCredit.val()
    };

    var responseMessages = {
        'success': 'Course Saved',
    };

    if(!validate(courseData['uid'],'uuid',true) && courseData['uid'] != null)
    {
        writeMessage(container,'danger','Error Processing Request: Data Missing. Please refresh and try again.');
    }

    if(!validate(courseTitle.val(),'alphaText',true))
    {
        writeMessage(container,'danger','Title must container alphabetic characters');
    }
    
    if(!validate(courseCaption.val(),'text',false) || courseCaption.val() == getAttr(courseCaption,'placeholder'))
    {
        writeMessage(container,'danger','Caption should only contain alphabetic, numeric, and puncuation characters');
    }

    if(!validate(courseDescription.val(),'text',true)|| courseDescription.val() == getAttr(courseDescription,'placeholder'))
    {
        writeMessage(container,'danger','Description should only contain alphabetic, numeric, and puncuation characters');
    }
    
    if(!validate(courseCredit.val(),'int',true))
    {
        writeMessage(container,'danger','Credit must be numeric');
    }

    if(hasErrors())
    {
        return false;
    }

    xhrSaveCourse(courseContainer,data);
 });

/**
 *	Click Delete Button
 */
courseDeleteButton.click(function(e){
	e.preventDefault();
	resetForm();

	var parentRow = $(this).closest('tr');
    var uuid = $(this).closest('td').attr('data-id');

    if(!validate(uuid,'uuid'))
    {
        writeMessage(courseContainer,'danger','Incorrect Data Sent. Please refresh the page and try again.');
        return false;
    }

    xhrDeleteCourse(courseContainer,{'uid':uuid});

    if(!hasErrors())
    {
    	tableRowDeleteAnimation(parentRow);
    }
});

function tableRowDeleteAnimation(parentRow)
{
    parentRow.addClass('alert-danger');
    parentRow.fadeOut(1000);
}