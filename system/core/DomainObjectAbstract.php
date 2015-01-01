<?php namespace System\Core;

abstract class DomainObjectAbstract
{
	protected $uid = null;



	/**
	 *	Get object unique ID
	 */
	public function getUid()
	{
		return $this->uid;
	}



	/**
	 *	Set the id for an object
	 */
	public function setUid($uid)
	{
		try
		{
			if(!is_null($this->getUid()))
			{
				throw new \Exception("Unique ID for domain object already set", 1);
			}

			$this->uid = $uid;
		}
		catch(\Exception $e)
		{
			print $e->getMessage();
		}
	}
}