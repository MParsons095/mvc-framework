<?php namespace Application\Controller;

use \System\Core\Controller;

class AdminController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->view->addVar('adminNav', APP_PATH . '/view/component/navigation/admin-navView.php');

		if(!isset($_SESSION) || !isset($_SESSION['accountType']) || $_SESSION['accountType'] != 'admin')
		{
			load_404();
		}
	}


	public function index()
	{
		$this->view->setTitle('Administration Panel');
		$this->view->addComponent('component/header/no-banner-head');
		$this->view->addComponent('admin/index');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function courses($action = null, $slug = null)
	{
		$this->view->setTitle('Courses | Administration Panel');
		$this->view->addJS('plugin/flexibleArea');
		$this->view->addJs('admin/course');
		$this->view->addJs('admin/courseMeta');
		$this->view->addJs('xhr/xhrLoad');
		$this->view->addJs('xhr/xhrCourse');
		$this->view->addJs('xhr/xhrCourseMeta');

		$this->load->mapper('Course');
		$this->load->model('Course');
		$this->CourseModel->setMapper($this->CourseMapper);

		$this->view->addComponent('component/header/no-banner-head');


		switch($action)
		{
			case null:
				$this->courseIndex();
				break;
			case 'view':
				$this->courseSingle($slug);
				break;
			case 'new':
				$this->courseNew();
				break;
			default:
				load_404();
				break;
		}

		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}

	private function courseIndex()
	{
		$this->view->addVar('courses',$this->CourseModel->getAllCourses());
		$this->view->addVar('response', $this->CourseModel->getResponse());
		$this->view->addComponent('admin/courseIndex');
	}


	private function courseSingle($slug)
	{
		if(!$slug)
		{
			load_404();
		}

		$result = $this->CourseModel->getCourse($slug);

		if(!$result)
		{
			load_404();
		}

		$this->load->model('CourseMeta');
		$this->load->mapper('CourseMeta');
		$this->CourseMetaModel->setMapper($this->CourseMetaMapper);

		//get curriculum
		$curriculum = $this->CourseMetaModel->getCurriculum(array('uid' => $result->getUid()));
		$this->view->addVar('courseCurriculum',$curriculum);

		//get requirements
		$requirements = $this->CourseMetaModel->getRequirements(array('uid' => $result->getUid()));
		$this->view->addVar('courseRequirements',$requirements);
		
		//set course data
		$this->view->addVar('uid',$result->getUid());
		$this->view->addVar('course',$result);

		//load required js files
		$this->view->addJs('xhr/xhrCourseMeta');

		//render view
		$this->view->addComponent('admin/courseSingle');
	}


	private function courseNew()
	{
		$this->view->addJs('xhrCourseMeta');
		$this->view->addVar('uid', null);
		$this->view->addComponent('admin/courseSingle');
	}





	public function events($slug = null)
	{
		
	}


	public function officers()
	{

	}


	public function accounts($slug = null)
	{
		
	}
}