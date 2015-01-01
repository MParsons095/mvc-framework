var searchInput = $('input[name="search-universities"]');
var searchResultsContainer = $('div[data-content="searchResults"]');
var keyupTimeout;
var timeoutInterval = 500;


$(document).ready(function(){
	searchResultsContainer.html('<p class="text-center"><b>Type something in the search box!</b></p><div class="text-center"><label>Example: You could type "University of Kentucky", "UK", or "Lexington" to search for University of Kentucky.</label></div>');
});


searchInput.keyup(function(e) {
	clearTimeout(keyupTimeout);
	var queryString = $(this).val();

	if (queryString == '' || $.trim(queryString) == '')
	{
		searchResultsContainer.html('<p class="text-center"><b>Type something in the search box!</b></p><div class="text-center"><label>Example: You could type "University of Kentucky", "UK", or "Lexington" to search for University of Kentucky.</label></div>');
	}
	else
	{
		searchResultsContainer.fadeOut();
		keyupTimeout = setTimeout(processSearch,timeoutInterval);
	};
});

function processSearch()
{
	var execFunc = {
		'success': appendSearchResults
	};

	xhrSearch(searchResultsContainer,{'queryString':searchInput.val()},execFunc);
	searchResultsContainer.fadeIn();
}


function appendSearchResults(result)
{
	if(result['response'][0] instanceof Array)
	{
		var str = '<table class="table table-hover"><thead>';
		str += '<th>Name</th><th>Location</th><th>Link to Program</th>';

		$.each(result['response'][0],function(key,val){
			str += '<tr><td>' + val['university'] + '</td><td>' + val['location'] + '</td><td><a href="' + val['link'] + '" target="blank">Visit Website</a></td></tr>';
		});

		str += '</table>';
	}
	else
	{
		str = '<p class="text-center"><b>No Results Found</b></p>';
	}

	searchResultsContainer.html(str);
}