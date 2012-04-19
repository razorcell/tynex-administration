<?php


class AuthenticationController extends Zend_Controller_Action
{

	public function init()
	{
		
	}
	public function indexAction()
	{
		$this->_forward('login');
	}
	public function loginAction()
	{
		$this->_helper->layout->setLayout('login');
		if(Zend_Auth::getInstance()->hasIdentity())
		{//logged in
			$this->view->message = 'You are already logged in';
			$this->_redirect('/');
		}
		else
		{//not logged in
			$request = $this->getRequest();
			$login_form = new Tynex_Forms_Login();
			if($request->isPost())
			{
				if($login_form->isValid($this->_request->getPost()))
				{
					$authAdapter = $this->getAuthAdapter();
					$username = $login_form->getValue('username');
					$password = $login_form->getValue('password');
						
					$authAdapter->setIdentity($username)
											->setCredential($password);
						
					$auth = Zend_Auth::getInstance();
					$result = $auth->authenticate($authAdapter);
						
					if($result->isValid())
					{//identification correct
						$identity = $authAdapter->getResultRowObject();
						$authStorage = $auth->getStorage();
						$authStorage->write($identity);
						$this->view->message = 'Authentification réussie, cliquer sur <strong>logout</strong> en haut à droite pour se déconnecter';
						$this->_redirect('/');
							
						//$this->render('loggedin');
					}
					else
					{//rong identification
						$this->view->message = 'invalid identifications';
						//$this->_redirect('/Authentication/login');
						//$this->render('logout');
					}
				}
				else
				{//invalid form inputs
					
				}
			}//end if request isPost()
			
		}//end else (not logged in)
		$this->view->form = $login_form;
	
	}
	
	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->view->message = 'you are logged out';
		$this->_redirect('/login');
		//$this->render('logout');
	}
	
	public function getAuthAdapter()
	{
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		$authAdapter->setTableName('employes')
					->setIdentityColumn('username')
					->setCredentialColumn('password');
		return $authAdapter;
	}
	
}



