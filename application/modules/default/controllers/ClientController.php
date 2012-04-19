<?php
class ClientController extends Zend_Controller_Action {
	private $ctrl = null;
	private $config = null;
	protected $db;
	public function init() { // 'ico gray administrator
		$this->view->general_icon = 'ico color user';
		$this->ctrl = $this->_request->getControllerName ();
		$this->view->ctrl = $this->ctrl;
		
		
		$this->config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
		// try connection to database
		try {
			$this->db = Zend_Db::factory ( $this->config->database );
			$this->db->getConnection ();
		} catch ( Zend_Db_Adapter_Exception $e ) {
			echo $e->getMessage ();
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
	}
	public function indexAction() {
		$this->view->title = 'Clients';
		
		
		$sql = 'SELECT * FROM clients';
		$this->view->list_clients = $this->db->fetchAssoc ( $sql );
	}
	public function addAction() {
		$this->view->title = 'Ajouter un client';
		// $add_client_form = new Tynex_Forms_Addclient();
		// $this->view->form = $add_client_form;
	}
	public function modifyAction() {
	
	}
	public function deleteAction() {
	
	}
	public function profilAction() {
		$this->view->title = 'Profil';
		$this->view->general_icon = 'ico color clipboard';
	}
	
	public function testAction() {
	
	}
	
	public function getClientsAction() {
		// $this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender();
	}
	
	public function displayAction() {
		
// 		 $page = $this->getRequest()->getParam('page'); if
// 		 (file_exists($this->view->getScriptPath(null) . "/" .
// 		 getScriptPath() return the path of the 'scripte' folder wich is
// 		 unique $this->getRequest()->getControllerName() . "/$page." .
// 		 $this->viewSuffix))//viewSuffix() returns the extention of view files
// 		 'Phtml' { if($page == 'add') { $form_add_client = new
// 		 Tynex_Form_AddClient(); $this->view->form = $form_add_client; }
// 		 $this->render($page); } else { throw new
// 		 Zend_Controller_Action_Exception('tynexADMIN: Page not found', 404);
// 		 }
		
	}

}

