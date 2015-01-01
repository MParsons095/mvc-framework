<?php namespace Application\Controller;

use \System\Core\Controller;

class AboutController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index() {}

	public function meet_the_development_team()
	{
		$this->view->setTitle('Meet the Design Team');

		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('about/meet-the-development-team');
		$this->view->addComponent('component/footer/default-foot');

		$this->view->render();
	}

	public function building_this_website()
	{
		$this->view->setTitle('Building this Website');

		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('about/building-this-website');
		$this->view->addComponent('component/footer/default-foot');

		$this->view->render();
	}
}