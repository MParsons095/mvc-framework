<?php namespace Application\Controller;

use \System\Core\Controller;

class DepartmentController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
    {
    	print 'department controller';
    }
    
    
	public function instructor()
	{
		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('department/instructor');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function higher_education()
	{
		$this->view->addJs('xhr/xhrLoad');
		$this->view->addjs('xhr/xhrEducationProgram');
		$this->view->addJs('department/searchHigherEducation');

		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('department/higher-education');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function contact()
	{
		$this->view->setTitle('Contact');
		$this->view->addJs('plugin/flexibleArea');
		$this->view->addComponent('component/header/contact-head');
		$this->view->addComponent('department/contact');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}
}