<?php namespace Application\Controller;

use \System\Core\Controller;

class AccountController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->request->redirectTo('account/profile');
	}


	public function logout()
	{
		$this->session->end();
		$this->request->redirectTo('');
	}


	public function profile()
	{
		//throw an error if user is not logged in
		$this->request->revokeNullSessionAccess($this->session);

		//load account model and mapper
		$this->load->mapper('Account');
		$this->load->model('Account');
		$this->AccountModel->setMapper($this->AccountMapper);

		//retrive account information
		$this->view->addVar('accountData',$this->AccountModel->findByUid($_SESSION['uid']));

		//retrive account meta
		$this->load->mapper('AccountMeta');
		$this->load->model('AccountMeta');
		$this->AccountMetaModel->setMapper($this->AccountMetaMapper);
		$accountMeta = $this->AccountMetaModel->findByAccountUid($_SESSION['uid']);

		$this->view->addVar('editable',true);

		//load javascript files for profile pages
		$this->view->addJs('xhr/xhrLoad');
		$this->view->addJs('plugin/flexibleArea');
		$this->view->addJs('library/imageCropper');

		//load site header
		$this->view->addComponent('component/header/default-head');

		//if account meta doesn't exit, load account setup page
		if($accountMeta)
		{
			$this->view->setTitle('Profile');
			$this->view->addJs('account/project');
			$this->view->addJs('xhr/xhrProject');
			$this->view->addJs('account/award');
			$this->view->addJs('xhr/xhrAward');
			$this->view->addVar('accountMeta',$accountMeta);

			$this->load->mapper('AwardMeta');
			$this->view->addVar('awardMeta',$this->AwardMetaMapper->selectAll());

			$this->view->addComponent('account/profile');
		}
		else
		{
			$this->view->setTitle('Profile Setup');
			$this->view->addComponent('account/profile-setup');

			//load profile setup js fils
			$this->view->addJs('account/setup');
			$this->view->addJs('xhr/accountSetup');
		}

		//load the footer and render out the page
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function register()
	{
		$this->view->setTitle('Register');
		$this->view->addJs('xhr/xhrLoad');
		$this->view->addJs('xhr/xhrAccount');
		$this->view->addJs('account/register');
		$this->view->addComponent('component/header/default-head');
		$this->view->addComponent('account/register');
		$this->view->addComponent('component/footer/default-foot');
		$this->view->render();
	}


	public function xhrLogin()
	{
		$this->request->revokeActiveSessionAccess($this->session);
		$this->request->revokeDirectAccess();
		$this->load->mapper('Account');
		$this->load->model('Login');
		$this->LoginModel->setMapper($this->AccountMapper);
		$this->LoginModel->setObject($this->AccountMapper->create());

		$this->LoginModel->run($_POST);
		$this->write('json',$this->LoginModel->getResponse());
	}


	public function xhrRegister()
	{
		$this->load->mapper('Account');
		$this->load->model('Register');
		$this->RegisterModel->setMapper($this->AccountMapper);
		$this->RegisterModel->setObject($this->AccountMapper->create());

		$this->RegisterModel->run($_POST);
		$this->write('json',$this->RegisterModel->getResponse());

	}
}