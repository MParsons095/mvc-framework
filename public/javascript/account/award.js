var awardsContainer = $('#achievements');
var awardsTable = $('table[data-content="loadedAwards"] tbody');
var saveAwardButton = $('input[type="submit"][name="saveAward"]');
var awardStats = $('div[data-content="achievementCount"]');
var awardToRemove = null;

$(document).ready(function(){
	loadAwardsIntoTable();
});


saveAwardButton.click(function(e){
	e.preventDefault();
	resetForm();

	var saveAwardModal = $('#saveAwardModal .modal-body');
	var awardCompetition = $('select[name="saveAwardCompetition"]');
	var awardPlacing = $('select[name="saveAwardPlacing"');
	var awardYearOf = $('select[name="saveAwardYear"]');
	var awardLevel = $('select[name="saveAwardLevel"]');
	var currYear = new Date().getFullYear();

	if( !validate(awardCompetition.val(),'uuid',true) ||
		!validateInArray(awardCompetition.val(),awardMeta)
		)
	{
		writeMessage(saveAwardModal,'danger','Invalid Competition');
	}

	if( !validate(awardPlacing.val(),'int') ||
		!validateRange(1,10,awardPlacing.val()))
	{
		writeMessage(saveAwardModal,'danger','Placing must be a numeric value between 1 and 10');
	}

	if( !validate(awardYearOf.val(),'int') ||
		!validateRange( currYear - 20, currYear, awardYearOf.val())
		)
	{
		writeMessage(saveAwardModal,'danger','Year must be in the range ' + (currYear - 20)  + ' and ' + new Date().getFullYear());
	}


	if( !validate(awardLevel.val(),'alpha') ||
		!validateInArray(awardLevel.val(),awardLevels)
		)
	{
		writeMessage(saveAwardModal,'danger','Invalid competition level given');
	}


	if(hasErrors())
	{
		return false;
	}


	var data = {
		'accountUid':AccountData['uid'],
		'awardMetaUid':awardCompetition.val(),
		'placing':awardPlacing.val(),
		'yearOf':awardYearOf.val(),
		'level':awardLevel.val()
	};

	var callBackFunc = {
		'success':loadAwardsIntoTable
	};

	xhrSaveAward(saveAwardModal,data,callBackFunc);
});

awardsTable.on('click','button[data-action="delete"]',function(e){
	e.preventDefault();
	resetForm();

	if(!validate($(this).attr('data-id'),'uuid',true))
	{
		writeMessage('Internal Error: Invalid ID Provided.');
		return false;
	}

	awardToRemove = $(this).parent().parent();


	var callBackFunc = {
		'success':removeDeletedAward,
	};

	xhrDeleteAward(awardsContainer,{'uid':$(this).attr('data-id')},callBackFunc);
});


function removeDeletedAward(xhr)
{
	awardToRemove.addClass('alert-danger');
	awardToRemove.fadeOut(1000);

	setTimeout(function(){
		awardToRemove.remove();
		awardToRemove = null;
		updateAwardStats(null);
	});
}


function loadAwardsIntoTable(editable)
{
	var data = {'uid':AccountData['uid']};

	var callBackFunc = {
		'success': appendAwards,
		'complete': updateAwardStats
	};
	xhrSelectAwardsByAccount(awardsContainer,data,callBackFunc);
}

function appendAwards(xhr)
{
	var awards = '';
	for(i = 0; i < xhr.response[0].length; i++)
	{
		awards += '<tr><td>' + xhr.response[0][i]['competition'] + '</td>' +
			'<td>' + xhr.response[0][i]['placing'] + '</td>' +
			'<td>' + xhr.response[0][i]['level'].charAt(0).toUpperCase() + xhr.response[0][i]['level'].slice(1) + '</td>' +
			'<td>' + xhr.response[0][i]['yearOf'] + '</td>';
		if(AccountData['editable'])
		{
			awards += '<td><button data-action="delete" data-id="' + xhr.response[0][i]['uid'] + '" class="btn btn-blue">Delete</button>';
		}
	}

	awardsTable.html(awards);
}


function updateAwardStats(xhr)
{
	awardStats.html($('table[data-content="loadedAwards"] tbody tr').length);
}

