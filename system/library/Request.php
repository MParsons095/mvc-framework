<?php namespace System\Library;

class Request
{
	/**
	 *	Checks if a page is being accessed directly or through
	 *	a xhr (ajax) request.
	 *
	 *	@return boolean - true if requested through ajax | false if requested directly
	 */
	public function isAjax()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			return true;
		}

		return false;
	}


	/**
	 *	Redirects to a new page.
	 *
	 *	@var String $location - the url of the page to redirect to.
	 *						  (the provided URL should exclude the domain root)
	 *	@return void
	 */
	public function redirectTo($location)
	{
		ob_start();
		header('location: ' . DOMAIN_ROOT . $location);
		ob_clean();
	}


	/**
	 *	Throws an "Internal Error" message if the current page
	 *	requires a session, and one is not given.
	 *
	 *	@var Session $Session - instance of Session
	 *	@return void
	 */
	public function revokeNullSessionAccess(Session $Session)
	{
		if(!$Session->get('id'))
		{
			load_internal_error('You must be logged in to access this page');
		}
	}


	/**
	 *	Throws an "Internal Error" message if the user
	 *	requests a page where a session should not
	 *	be active, such as a login page.
	 *	
	 *	@var Session $Session - instance of Session
	 *	@return void
	 */
	public function revokeActiveSessionAccess(Session $Session)
	{
		if($Session->get('id'))
		{
			load_404();
		}
	}


	/**
	 *	Throws a 404 error if a ajax page is directly accessed.
	 *
	 *	@return void
	 */
	public function revokeDirectAccess()
	{
		if(!$this->isAjax())
		{
			load_404();
		}
	}


	/**
	 *	Throws a 404 error if a non-ajax page is accessed
	 *	through a xhr request.
	 *
	 *	@return void
	 */
	public function revokeAjaxAccess()
	{
		if($this->isAjax())
		{
			load_404();
		}
	}
}