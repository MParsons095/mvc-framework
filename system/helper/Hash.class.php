<?php namespace System\Helper;

class Hash
{
	public function generateSha256($password,$salt)
	{
		return hash('sha256', $salt.$password);
	}

	public function salt()
	{
		return md5(uniqid(rand()));
	}
}