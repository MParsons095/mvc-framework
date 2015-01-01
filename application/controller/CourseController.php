<?php namespace Application\Controller;

use \System\Core\Controller;

class CourseController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		load_404();
	}


	public function view($slug)
	{
		$this->load->model('Course');
		$this->load->mapper('Course');
		$this->load->domainObject('Course');
		$this->CourseModel->setMapper($this->CourseMapper);
		$this->CourseModel->setObject($this->CourseObject);

		$result = $this->CourseModel->getCourse($slug);

		if(!$result)
		{
			load_404();
		}

		$this->load->model('CourseMeta');
		$this->load->mapper('CourseMeta');
		$this->CourseMetaModel->setMapper($this->CourseMetaMapper);
		$this->view->addVar('courseRequirements',$this->CourseMetaModel->getRequirements(array('uid' => $result->getUid())));
		$this->view->addVar('courseCurriculum',$this->CourseMetaModel->getCurriculum(array('uid' => $result->getUid())));

		$this->view->addVar('course',$result);

		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('course/view-course');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}
}