<?php namespace Application\Controller;

use \System\Core\Controller;

class XhrCrudController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		//$this->request->revokeDirectAccess();
	}

	public function index()
	{
		load_404();
	}


	public function course($action)
	{
		$this->load->mapper('Course');
		$this->load->model('Course');
		$this->CourseModel->setMapper($this->CourseMapper);
		$this->CourseModel->setObject($this->CourseMapper->create());

		switch ($action)
		{
			case 'selectSingle':
				$this->CourseModel->selectSingle($_POST);
				break;
			case 'selectAll':
				$this->CoruseModel->selectAll($_POST);
				break;
			case 'save':
				$this->CourseModel->save($_POST);
				break;
			case 'delete':
				$this->CourseModel->delete($_POST);
				break;
			default:
				return false;
				break;
		}

		$this->write('json',$this->CourseModel->getResponse());
	}


	public function courseMeta($action)
	{
		$this->load->mapper('CourseMeta');
		$this->load->model('CourseMeta');
		$this->CourseMetaModel->setMapper($this->CourseMetaMapper);
		$this->CourseMetaModel->setObject($this->CourseMetaMapper->create());
		
		switch($action)
		{
			case 'selectSingle':
				$this->CourseMetaModel->selectSingle($_POST);
				break;
			case 'selectAll':
				$this->CourseMetaModel->selectAll($_POST);
				break;
			case 'selectCurriculum':
				$this->CourseMetaModel->getCurriculum($_POST);
				break;
			case 'selectRequirements':
				$this->CourseMetaModel->getRequirements($_POST);
				break;
			case 'selectWhere':
				$this->CourseMetaModel->selectWhere($_POST);
				break;
			case 'getCurriculumByParent':
				$this->CourseMetaModel->getCurriculumByParent($_POST);
				break;
			case 'save':
				$this->CourseMetaModel->save($_POST);
				break;
			case 'delete':
				$this->CourseMetaModel->delete($_POST);
				break;
			default:
				return false;
				break;
		}

		$this->write('json',$this->CourseMetaModel->getResponse());
	}


	public function account($action)
	{
		$this->load->mapper('Account');
		$this->load->model('Account');
		$this->AccountModel->setMapper($this->AccountMapper);

		switch($action)
		{
			case 'save':
				$this->load->model('Register');
				$this->RegisterModel->setMapper($this->AccountMapper);
				$this->RegisterModel->run($_POST);
				$this->write('json',$this->RegisterModel->getResponse());
				break;
			default:
				return false;
				break;
		}
	}


	public function accountMeta($action)
	{
		$this->load->mapper('AccountMeta');
		$this->load->model('AccountMeta');
		$this->AccountMetaModel->setMapper($this->AccountMetaMapper);

		switch($action)
		{
			case 'save':
				$this->AccountMetaModel->save($_POST);
				break;
			default:
				return false;
				break;
		}
		
		$this->write('json',$this->AccountMetaModel->getResponse());
	}


	public function imageCropper($action)
	{
		switch($action)
		{
			case 'process':
				$imageCropper = load_class('ImageCropper','system/library');
				$imageCropper->run($_POST);

				$this->write('json',$imageCropper->getResponse());
				break;
			default:
				return false;
				break;
		}
	}


	public function award($action)
	{
		$this->load->model('Award');
		$this->load->mapper('Award');
		$this->AwardModel->setMapper($this->AwardMapper);

		switch ($action)
		{
			case 'selectAll':
				$this->AwardModel->selectAllByAccountUid($_POST);
				break;
			case 'save':
				$this->AwardModel->save($_POST);
				break;
			case 'delete':
				$this->AwardModel->delete($_POST);
				break;
			default:
				return false;
				break;
		}

		$this->write('json',$this->AwardModel->getResponse());
	}



	public function project($action)
	{
		$this->load->model('Project');
		$this->load->mapper('Project');
		$this->ProjectModel->setMapper($this->ProjectMapper);
		
		switch ($action)
		{
			case 'selectByAccount':
				$this->ProjectModel->selectByAccount($_POST);
				break;
			case 'save':
				$this->ProjectModel->save($_POST);
				break;
			default:
				return false;
		}

		$this->write('json',$this->ProjectModel->getResponse());
	}



	public function projectMeta($action)
	{
		$this->load->model('ProjectMeta');
		$this->load->mapper('ProjectMeta');
		$this->ProjectMetaModel->setMapper($this->ProjectMetaMapper);

		$this->ProjectMetaModel->save(array(
			'uid' => null,
			'accountUid' => '5d841f9a-be02-11e3-9690-88ae1de0dfc2',
			'projectUid' => '5d841f9a-be02-11e3-9690-88ae1de0dfc2',
			'role' => 'testing role'
		));

		$this->write('json',$this->ProjectMetaModel->getResponse());
	}



	public function educationProgram($action)
	{
		$this->load->model('EducationProgram');
		$this->load->mapper('EducationProgram');
		$this->EducationProgramModel->setMapper($this->EducationProgramMapper);

		switch($action) {
			case 'selectAll':
				$this->EducationProgramModel->selectAll();
				break;
			case 'search':
				$this->EducationProgramModel->search($_POST);
				break;
			default:
				return false;
				break;
		}

		$this->write('json',$this->EducationProgramModel->getResponse());
	}
}