<?php namespace System\ClassInterface;

interface Validator
{
	public function getResponse();
	public function addError($message);
	public function addSuccess($message);
}