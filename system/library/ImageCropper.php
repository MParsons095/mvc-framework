<?php namespace System\Library;
use \System\Core\ServiceAbstract;

class ImageCropper extends ServiceAbstract
{
	private $image;
	private $imageWidth;
	private $imageHeight;
	private $imageType;
	private $top;
	private $left;
	private $cropWidth;
	private $cropHeight;


	public function run($data)
	{
		if( !isset($data['top']) ||
			!isset($data['left']) ||
			!isset($data['img']) ||
			!isset($data['imgWidth']) ||
			!isset($data['imgHeight']) ||
			!isset($data['imgType']) ||
			!isset($data['cropWidth']) ||
			!isset($data['cropHeight'])
		)
		{
			$this->addError('Internal Error: Missing Data');
			return false;
		}

		$this->image = $this->validator->sanitize($data['img']);
		$this->imageWidth = $this->validator->sanitize($data['imgWidth']);
		$this->imageHeight = $this->validator->sanitize($data['imgHeight']);
		$this->imageType = $this->validator->sanitize($data['imgType']);
		$this->top = $this->validator->sanitize($data['top']);
		$this->left = $this->validator->sanitize($data['left']);
		$this->cropWidth = $this->validator->sanitize($data['cropWidth']);
		$this->cropHeight = $this->validator->sanitize($data['cropHeight']);

		if(!$this->validate())
		{
			$this->addError($data);
			return false;
		}

		$response = $this->processImage();
		if($response)
		{
			$this->addSuccess($response);
			return true;
		}

		$this->addError('Failed to Upload Image');
		return true;
	}

	public function validate()
	{
		/*if(!$this->validator->validate($this->image))////////////
		{
			$this->addError();
		}*/

		if(!$this->validator->validate($this->imageWidth,'int'))
		{
			$this->addError('Image Width Must Be Numeric');
		}

		if(!$this->validator->validate($this->imageHeight,'int'))
		{
			$this->addError('Image Height Must Be Numeric');
		}

		if(!$this->validator->validate($this->imageType,'alpha'))
		{
			$this->addError('Image Type must be alphabetic');
		}

		if(!$this->validator->validate($this->top,'int'))
		{
			$this->addError('Image \'Top\' Position Must Be Numeric');
		}

		if(!$this->validator->validate($this->left,'int'))
		{
			$this->addError('Image \'Left\' Position Must Be Numeric');
		}

		if($this->hasErrors())
		{
			return false;
		}

		return true;
	}


	private function processImage()
	{
		//width and height of crop
		$dimesions = 200;

		//scales from 0 to 100
		$quality = 100;

		//original image
		$image = $this->image;

		//create new image
		$newImage = null;



		switch($this->imageType)
		{
			case 'jpg':
			case 'jpeg':
				$newImage = imagecreatefromjpeg($image);
				break;
			case 'png':
				$newImage = imagecreatefrompng($image);
				break;
			case 'gif':
				$newImage = imagecreatefromgif($image);
				break;
			default:
				return false;
		}

		//create cropped field
		$dst = imagecreatetruecolor($this->cropWidth,$this->cropHeight);

		//generate unique id
		$uid = uniqid(rand());

		//resample original
		imagecopyresampled($dst, $newImage, 0, 0, $this->left, $this->top, $this->imageWidth, $this->imageHeight, $this->imageWidth, $this->imageHeight);


		$path = SERVER_ROOT . 'public/temp/image';

		if(!file_exists($path))
		{
			mkdir($path, 0777, true);
		}

		imagejpeg($dst,$path . '/' . $uid . '.jpg',$quality);
		return $uid;
	}
}