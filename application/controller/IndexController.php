<?php namespace Application\Controller;

use \System\Core\Controller;

class IndexController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->load->model('Project');
		$this->load->mapper('Project');
		$this->ProjectModel->setMapper($this->ProjectMapper);

		$this->view->addVar('projects',$this->ProjectModel->selectAll());

		$this->view->addComponent('component/header/index-head');
		$this->view->addComponent('index/home');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}
}