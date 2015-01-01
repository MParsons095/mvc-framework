<?php namespace System\Library;

class DataWriter
{
	protected $writer;
	protected $WriterType;
	protected $WriterData;



	public function write($type,$data)
	{
		$this->type = ucfirst($type);
		$this->data = $data;
		$class = '\System\Library\\' . $this->type . 'Writer';


		if(class_exists($class))
		{
			$writer = new $class();
		}
		else
		{
			$class = '\System\Library\JsonWriter';
			$writer = new $class();
		}
		
		$writer->write($this->data);
	}
}