<?php namespace System\Library;

class Session
{
	private $domain;
	private $relPath;
	private $userAgent;
	private $ip;


	public function __construct()
	{
		$this->config = load_class('Config','System/Core');
	}


	/**
	 *	Start the session if it doesn't already exit.4
	 */
	public function initSession()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}


	/**
	 *	Initialize the session and set default session values.
	 *
	 *	@var String $relPath - 
	 */
	public function start($relPath = null)
	{
		$this->initSession();
		//$this->domain = $this->config->get('url/domain');
		//$this->relPath = ($relPath) ? $relPath : $this->config->get('url/relPath');
		$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->ip = $_SERVER['REMOTE_ADDR'];

		$_SESSION['userAgent'] = $this->userAgent;
		$_SESSION['ip'] = $this->ip;

	}


	/**
	 *	Prevent session hijacking by comparing the current user agent,
	 *	IP address, and id with the values of the three from when
	 *	the user first logged in.
	 *
	 *	End the session if the current data does not match the original.
	 */
	public function secureSession()
	{
		if(!isset($this->userAgent) || !isset($this->ip))
		{
			$this->end();
		}


		if($this->userAgent != $_SERVER['HTTP_USER_AGENT'])
		{
			$this->end();
		}


		if($this->ip != $_SERVER['REMOTE_ADDR'])
		{
			$this->end();
		}
	}


	/**
	 *	Validates session, then checks if user is logged in.
	 *
	 *	@return boolean
	 */
	public function validSession()
	{
		$this->secureSession();

		if($this->get('id'))
		{
			return true;
		}

		return false;
	}


	/**
	 *	Add a new value to $_SESSION array.
	 *
	 *	@var String $key - the reference key for the value in the $_SESSION array
	 *	@var mixed $value - the value to be added to the $_SESSION array
	 *	@return void
	 */
	public function set($key,$value)
	{
		$_SESSION[$key] = $value;
	}


	/**
	 *	Get a value from the $_SESSION array. Return null if the provided
	 *	key doesn't exist withing the array.
	 *
	 *	@var String $key - the reference key for the value in the $_SESSION array
	 */
	public function get($key)
	{
		if(isset($_SESSION[$key]))
		{
			return $_SESSION[$key];
		}

		return null;
	}


	/**
	 *	Destroy the session, logging the user out, and
	 *	restart it.
	 */
	public function end()
	{
		session_unset();
		$_SESSION = null;
		session_destroy();

		ob_start();
		session_start();
		ob_clean();
	}
}