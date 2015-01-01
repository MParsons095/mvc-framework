/**
 *	Declare required variables
 */
var cropWrapper = $('#image-cropper[data-role="imageCropperProcessingContainer"]');
var originalImageContainer = $('.prep-container[data-role="crop-original"]');
var originalImage = $('.originalImage');
var previewImageContainer = $('.prep-container[data-role="crop-preview"]');
var previewImageDiv = $('.prep-container[data-role="crop-preview"] .preview-fixed');
var previewImage = $('.prep-container[data-role="crop-preview"] .crop-preview');
var selectPictureButton = $('button[data-action="selectPicture"]');
var imageFileSelector = $('input[type="file"][name="imageFileSelector"]');
var uploadImageButton = $('button[data-action="uploadImage"]');
var uploadedImage = $('input[type="hidden"][name="uploadedImage');
var resetImageCropper = $('button[data-action="resetImageCropper"]');

var originalImageSource;
var originalImageType;
var originalWidth;
var originalHeight;


/**
 *	On click, open file explorer
 */
selectPictureButton.click(function(e){
	e.preventDefault();
	imageFileSelector.click();
});




imageFileSelector.change(function (){
	var fileName = $(this).val();
	originalImageType = $(this).val().split('.').pop().toLowerCase();
	
	if(fileName != '')
	{
		if($.inArray(originalImageType, ['png','jpg','jpeg']) == -1)
		{
			writeMessage(originalImageContainer,'danger',"Invalid File Type");
			return false;
		}

		displayImage(this);
		uploadImageButton.fadeIn();
		selectPictureButton.removeClass('btn-blue');
		selectPictureButton.addClass('btn-grey');
		selectPictureButton.html('Choose Another Picture');

		if(originalImageContainer.attr('data-ratio') == 'undefined' ||
			originalImageContainer.attr('data-ratio') == null)
		{
			originalImageContainer.imgAreaSelect({
				minWidth: 50,
				minHeight:50,
				aspectRatio: "1:1",
				handles:true,
				hide:false,
				onSelectChange: setDimensions,
				onSelectEnd: function (img, selection) {
	            	$('input[name="x1"]').val(selection.x1);
	            	$('input[name="y1"]').val(selection.y1);
	            	$('input[name="x2"]').val(selection.x2);
	            	$('input[name="y2"]').val(selection.y2);            
	        	}
			});
		}
		else
		{
			originalImageContainer.imgAreaSelect({
				minWidth: 50,
				minHeight:50,
				aspectRatio: originalImageContainer.attr('data-ratio'),
				handles:true,
				hide:false,
				onSelectChange: setDimensions,
				onSelectEnd: function (img, selection) {
	            	$('input[name="x1"]').val(selection.x1);
	            	$('input[name="y1"]').val(selection.y1);
	            	$('input[name="x2"]').val(selection.x2);
	            	$('input[name="y2"]').val(selection.y2);            
	        	}
			});
		}
	}
});


function setDimensions(img,selection)
{
	$("#x1").val(selection.x1);
	$("#y1").val(selection.y1);
	$("#x2").val(selection.x2);
	$("#y2").val(selection.y2);
	$("#w").val(selection.width);
	$("#h").val(selection.height);
}



function displayImage(file)
{
	if(file.files && file.files[0])
	{
		var reader = new FileReader();
		reader.readAsDataURL(file.files[0]);

		reader.onload = function(e)
		{
			var theImage = new Image();
			theImage.src = e.target.result;
			originalWidth = theImage.width;
			originalHeight = theImage.height;

			if(originalWidth < 200 || originalHeight < 200)
			{
				writeMessage(originalImageContainer,"danger","<b>Image is too small:</b> Dimesions of image must be at least 200 x 200 pixels");
				return false;
			}

			originalImageContainer.html('<img class="originalImage" src="' + e.target.result + '" />');
			previewImage.attr('src',e.target.result);
			originalImageSource = e.target.result;
		}
	}
}


function preview(xhr)
{
	uploadedImage.attr('value',xhr.response[0]);
	previewImageContainer.html('<img src="' + getRoot() + '/public/temp/image/' + uploadedImage.val() + '.jpg" />');
	previewImageContainer.attr('data-value',uploadedImage.val());
	previewImageDiv.css('display','block');

	originalImageContainer.imgAreaSelect({
		hide:true
	});
}



uploadImageButton.click(function(e){
	e.preventDefault();

	//ratio of the original image width to current
	var widthRatio = (originalImageContainer.width() - 4) / originalWidth;
	var heightRatio = (originalImageContainer.height() - 4) / originalHeight;

	//crop position from top
	var top = Math.round($('input[name="y1"]').val() / heightRatio);

	//crop position from left
	var left = Math.round($('input[name="x1"]').val() / widthRatio);

	//crop width
	var cropWidth = Math.round(($('input[name="x2"]').val() - $('input[name="x1"]').val())/widthRatio);

	//crop height
	var cropHeight = Math.round(($('input[name="y2"]').val() - $('input[name="y1"]').val())/widthRatio);
	

	processPortrait(top,left,originalWidth,originalHeight,originalImageSource,originalImageType,cropWidth,cropHeight);

	resetImageCropper.fadeIn();
	return false;
});


resetImageCropper.click(function(e){
	e.preventDefault();

	uploadedImage.val(null);
	previewImageContainer.html('<span class="watermark">Preview</span>');
	previewImageContainer.attr('data-value',false);

	$(this).fadeOut();
});



function processPortrait(top,left,width,height,image,imgType,cropWidth,cropHeight)
{
	selectPictureButton.attr('disabled','disabled');
	uploadImageButton.attr('disabled','disabled');

	var container = $('[data-role="portraitProccessingContainer"]');
	var data = {
		'top':top,
		'left':left,
		'imgWidth':width,
		'imgHeight':height,
		'img':image,
		'imgType':imgType,
		'cropWidth':cropWidth,
		'cropHeight':cropHeight
	};

	var responseMessages = {
		'success':'Portrait Uploaded',
		'error':'Failed to Upload Portrait'
	};
	
	var callbackFunc = {
		'success':preview
	};

	xhrLoad('xhrCrud/imageCropper/process',previewImageContainer,data,responseMessages,callbackFunc);

	selectPictureButton.removeAttr('disabled');
	uploadImageButton.removeAttr('disabled');
	
	return false;
}