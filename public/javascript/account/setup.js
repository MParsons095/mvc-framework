/**
 *	Form fields
 */
var summaryContainer = $('#summary');
var yearJoined = $('select[name="yearJoined"]');
var bio = $('textarea[name="bio"]');
var pictureUploadButton = $('button[data-action="uploadImage"]');
var profilePicEncoding = $('input[name="uploadedImage"]');
var saveAccountMeta = $('input[name="saveAccountMeta"]');


/**
 *	Summary fields
 */
var summaryBio = $('p[data-content="bio"]');
var summaryYearJoined = $('div[data-content="yearJoined"]');
var summaryPicture = $('img[data-content="profile-picture"]');



/**
 *	state change functions
 */

//year joined <select>
yearJoined.change(function(){
	summaryYearJoined.html(yearJoined.val());
});

//bio textarea
bio.change(function(){
	summaryBio.html(bio.val());
});

//uploaded picture
pictureUploadButton.click(function(){
	setTimeout(function(){
		if( profilePicEncoding.val() != "null" &&
			profilePicEncoding.val() != null
			)
		{
			summaryPicture.attr('src',getRoot() + 'public/temp/image/' + profilePicEncoding.val() + '.jpg');
		}
		else
		{
			summaryPicture.attr('src',getRoot() + 'public/image/graphic/profile-placeholder.jpg');
		}
	},3000);
});

//profile picture reset
$('button[data-action="resetImageCropper"]').click(function(){
	summaryPicture.attr('src',getRoot() + 'public/image/graphic/profile-placeholder.jpg');
});


/**
 *	action functions
 */
 saveAccountMeta.click(function(e){
    e.preventDefault();
    resetForm();

    if(!validate(yearJoined.val(),'int',true))
    {
    	writeMessage(summaryContainer,'danger','Invalid value for \'Year Joined\' field');
    }

    if(!validate(bio.val(),'text',true))
    {
    	writeMessage(summaryContainer,'danger','Only alphbetic, numeric, and puncuation characters are allowed in the \'bio\' field');
    }

    if(!validate(profilePicEncoding.val(),'alphaNumeric',false))
    {
    	writeMessage(summaryContainer,'danger','Invalid profile picture provided. Please refresh and re-upload the picture.');
    }

    if(hasErrors())
    {
    	return false;
    }

    data = {
    	'accountUid':AccountData['uid'],
    	'yearJoined':yearJoined.val(),
    	'bio':bio.val(),
    	'picture':profilePicEncoding.val()
    };

    var callBackFunc = {
        'success':redirectToProfile
    };

    xhrSaveAccountMeta(summaryContainer,data,callBackFunc);
});

function redirectToProfile(xhr)
{
    if(xhr.state)
    {
        setRedirectCountdown(2,getRoot() + 'account/profile',null);
    }
}