<?php namespace Application\Controller;

use \System\Core\Controller;

class TsaController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Award');
		$this->load->mapper('Award');
		$this->AwardModel->setMapper($this->AwardMapper);

		$this->load->model('Account');
		$this->load->mapper('Account');
		$this->AccountModel->setMapper($this->AccountMapper);

		$this->load->model('Project');
		$this->load->mapper('Project');
		$this->ProjectModel->setMapper($this->ProjectMapper);

		$this->load->mapper('AwardMeta');
		$this->load->mapper('Officer');

		$membersCount = $this->AccountMapper->count();
		$projectsCount = $this->ProjectMapper->count();
		$awardsCount = $this->AwardMapper->count();

		$this->view->addVar('statistics',array(
			'members' => $membersCount['count'],
			'projects' => $projectsCount['count'],
			'awards' => $awardsCount['count']
		));
		
		$this->view->addVar('projectsList',$this->ProjectModel->selectAll());
		$this->view->addVar('competitions',$this->AwardMetaMapper->selectAll());
		$this->view->addVar('officers',$this->OfficerMapper->selectAll());

		$this->view->setTitle('TSA');
		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('tsa/tsaHome');
		$this->view->addComponent('component/footer/default-foot');

		$this->view->render();
	}

	public function members($action = null,$account = null)
	{
		$this->load->model('Account');
		$this->load->mapper('Account');
		$this->AccountModel->setMapper($this->AccountMapper);

		$this->load->mapper('Officer');
		$this->view->addVar('officers',$this->OfficerMapper->selectAll());

		$this->view->addComponent('component/header/default-head');
		
		switch ($action) {
			case null:
				$this->view->addVar('accountListing',$this->AccountModel->selectAllAccountData());
				$this->view->setTitle('Members');
				$this->view->addComponent('tsa/members');
				break;
			case 'view':
				$accountData = $this->AccountModel->findBySlug(array('slug' => $account));
				$this->view->addVar('editable',false);

				if(!is_object($accountData))
				{
					load_404();
				}

				$this->view->addVar('accountData',$accountData);
				$this->view->addJs('xhr/xhrLoad');
				$this->view->addJs('account/award');
				$this->view->addJs('xhr/xhrAward');
				$this->view->addJs('account/project');
				$this->view->addJs('xhr/xhrProject');
				$this->load->mapper('AccountMeta');
				$this->load->model('AccountMeta');
				$this->AccountMetaModel->setMapper($this->AccountMetaMapper);

				$accountMeta = $this->AccountMetaModel->findByAccountUid($accountData->getUid());
				$this->view->addVar('accountMeta',$accountMeta);
				$this->view->addComponent('account/profile');
				break;
			default:
				load_404();
				break;
		}

		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function awards()
	{
		$this->load->model('Award');
		$this->load->mapper('Award');
		$this->AwardModel->setMapper($this->AwardMapper);
		$this->view->addVar('awardList',$this->AwardModel->selectAll());

		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('tsa/awards');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function projects($slug = null)
	{
		$this->load->mapper('Project');

		$this->load->model('Project');
		$this->ProjectModel->setMapper($this->ProjectMapper);

		$this->view->setTitle('TSA Projects');
		$this->view->addComponent('component/header/default-head');

		if($slug)
		{
			$this->load->model('ProjectMeta');
			$this->load->mapper('ProjectMeta');
			$this->ProjectMetaModel->setMapper($this->ProjectMetaMapper);

			$project = $this->ProjectModel->findBySlug($slug);

			if(is_object($project))
			{
				$this->view->addVar('projectMeta',$this->ProjectMetaModel->selectProjectAccounts($project->getUid()));
				$this->view->addVar('project',$project);
				$this->view->addComponent('tsa/single-project');
			}
			else
			{
				print_r($project);
				load_404();
			}
		}
		else
		{
			$this->view->addVar('projectsList', $this->ProjectModel->selectAll());
			$this->view->addComponent('tsa/projects');
		}

		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}
}