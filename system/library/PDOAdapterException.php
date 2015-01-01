<?php namespace System\Library;

class PDOAdapterException
{
	public function getMessage($e)
	{
		switch($e->getCode())
		{
			case 23000:
				$error = $this->duplicateError($e->errorInfo[2]);
				break;
			default:
				$error = 'Internal Error: Could not complete request.';
				break;
		}

		return $error;
	}


	private function duplicateError($string)
	{
		$length = count($string);
		$start = strpos($string, '\'');
		$end = strpos($string,'\'', $start + 1);
		$offset = ($start - $end) * - 1;

		$value = substr($string,$start + 1,$offset - 1);

		$start = strpos($string, '\'', $end + 1);
		$end = strpos($string,'\'', $start + 1);
		$offset = ($start - $end) * - 1;

		$field = substr($string,$start + 1,$offset - 1);

		return  'Error: ' . ucfirst($field) . ' "' . $value . '" is already in use.';
	}
}