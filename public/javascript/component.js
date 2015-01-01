function writeMessage(object, type, message)
{
	object.prepend('<div class="alert alert-' + type + ' alert-dismissable">\
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\
				' + message +'</div>');
}


function listMessages(object, type, errors)
{
	console.log(errors)
	return;
	if(errors instanceof Array)
	{
		alert('test');
		for(var i = 0; i < errors.length(); i++)
		{
			writeMessage(object, type, errors[i]);
		}
	}
}


function resetForm()
{
	$('.alert').remove();
}


function getAttr(element,attribute)
{
	return element.attr(attribute);
}


function getRoot()
{
	var partial = window.location.pathname.split( '/' );
	return 'http://' + document.domain + '/' + partial[1] + '/';
}


function setLoader(element, set)
{
	if(set == false)
	{
		$('.loader img').fadeOut(1000);
		
		setTimeout(function(){
			$('.loader').slideUp(function(){
				$(this).remove();
			});
		},1000);
	}
	else
	{
		element.prepend('<div class="loader"><img src="' + getRoot() + 'public/image/gif/ajax-loader.GIF" class="loader-gif" />');
		$('.loader').fadeIn(1000);
	}
}


function splitUrl()
{
	var url = window.location.protocol;
	var path = window.location.pathname.split('/');
	return path;
}



function setRedirectCountdown(time,redirectTo,object)
{
	count = time;
	timer = setInterval(function(){countDown(object,redirectTo)}, 1000);
}

function countDown(object, redirectTo)
{
	if(object != null)
	{
		object.html(count);
	}

	count--;

	if(count < 0)
	{
		clearInterval(timer);
		window.location = redirectTo;
	}
}

$('[data-toggle="tab"]').click(function(e){
	e.preventDefault();
	$(this).tab('show');
});