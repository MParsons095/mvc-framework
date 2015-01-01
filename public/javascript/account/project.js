var projectsContainer = $('#projects div[data-content="projects"]');
var projectsCountContainer = $('[data-content="projectsCount"]');
var newProjectsContainer = $('#newProjectContent');
var newProjectsSave = $('[data-action="saveProject"]');


$(document).ready(function(){
	loadProjects();
});


$('textarea[name="newProjectDescription"]').keydown(function(e){
    var that = this;
    setTimeout(function(){
        $('div[data-content="newProjectDescription"]').html('<p>' + that.value.replace(/\n/g,"</p><p>") + '</p>');
    },10);
});




newProjectsSave.click(function(e){
	e.preventDefault();
	resetForm();

	title = $('input[name="newProjectTitle"]');
	description = $('div[data-content="newProjectDescription"]');
	image = $('input[name="uploadedImage"]');

	if(!validate(title.val(),'text',true))
	{
		writeMessage(newProjectsContainer,'danger','Please enter a title with only alphabetic characters');
	}


	if(!validate(description.html(),'html',true) && description.html() != '<p></p>')
	{
		writeMessage(newProjectsContainer,'danger','Please enter a description with only alphabetic characters');
	}


	if(!validate(image.val(),'alphaNumeric',true) || image.val() == 'null')
	{
		writeMessage(newProjectsContainer,'danger','Please re-upload your image');
	}

	if(hasErrors())
	{
		return false;
	}


	var data = {
		'author' : AccountData['uid'],
		'title' : title.val(),
		'description' : description.html(),
		'picture' : image.val()
	};

	var execFunc = {
		'success' : loadProjects
	}

	xhrSaveProject(newProjectsContainer,data,execFunc);
});


function loadProjects()
{
	var data = {
		'accountUid' : AccountData['uid']
	};

	var execFunc = {
		'success' : appendProjects
	};

	xhrLoadByAccountProjects(projectsContainer,data,execFunc);
}

function appendProjects(xhr)
{
	var numProjects = 0;

	projectsContainer.html('');
	$.each(xhr.response[0],function(key,value){
		projectsContainer.append('<div class="row"> ' +
			'<div class="col-md-3"><img src="' + getRoot() + 'public/system/image/' + value['picture'] + '.jpg" width="100%" /></div>' +
				'<div class="col-md-9">' +
					'<h2>' + value['title'] + '</h2>' +
						value['description'] +
						'<div class="text-center"><a href="' + getRoot() + 'tsa/projects/' + value['slug'] + '" class="btn btn-orange">Project Specs</a></div>' +
					'</div>' +
				'</div><hr />');
		numProjects++;
	});

	setProjectsCount(numProjects);
}


function setProjectsCount(numProjects)
{
	projectsCountContainer.fadeOut();
	projectsCountContainer.html(numProjects);
	projectsCountContainer.fadeIn();
}